<?php

namespace Deployer;

task('secrets:fetch', function () {
    if (!get('has_secrets_managed')) {
        return;
    }

    // Infisical CLI is expected to already be installed in the CI image
    // (handled at the pipeline level, not here).

    // If Infisical is unreachable, don't fail the whole deploy — leave whatever
    // is already in shared/.env alone and assume it's still good enough.
    try {
        $config = json_decode(file_get_contents(getcwd() . '/.infisical.json'), true);
        $projectId = $config['workspaceId'] ?? null;

        if (!$projectId) {
            throw new \RuntimeException('Could not find workspaceId in .infisical.json');
        }

        // Infisical's own --format=dotenv/dotenv-export escaping is broken for values
        // containing a literal single quote (it produces invalid dotenv syntax), so we
        // fetch as JSON and serialize the .env ourselves instead of trusting its output.
        $export = runLocally('infisical export --projectId=' . $projectId . ' --env=' . get('infisical_environment', 'production') . ' --format=json');
        $secrets = json_decode($export, true);

        if (!is_array($secrets)) {
            throw new \RuntimeException('Unexpected response from infisical export');
        }

        $lines = [];
        foreach ($secrets as $secret) {
            if (!isset($secret['key'], $secret['value']) || !is_string($secret['value'])) {
                throw new \RuntimeException('Unexpected secret shape from infisical export');
            }

            // symfony/dotenv treats an unescaped $ in a double-quoted value as a variable
            // reference (e.g. $HOME, ${HOME}) — escape it so bcrypt hashes etc. stay literal.
            $value = str_replace('$', '\\$', json_encode($secret['value'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $lines[] = $secret['key'] . '=' . $value;
        }
        $export = implode("\n", $lines);
    } catch (\Throwable $e) {
        writeln('<comment>Could not fetch secrets from Infisical (' . $e->getMessage() . ') — leaving the existing shared .env in place.</comment>');
        return;
    }

    $local = getcwd() . '/.env.infisical';
    file_put_contents($local, rtrim(get('secrets_managed_comment')) . "\n\n" . $export . "\n");

    run('mkdir -p {{deploy_path}}/shared');
    upload($local, '{{deploy_path}}/shared/.env');

    runLocally('rm -f ' . $local);
})->desc('Overwrite the shared .env with fresh secrets from Infisical')->hidden();
