<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:setup-application';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare application for initial user';

    public function handle()
    {
        $this->warn('Setting up encryption key');
        $this->setKeyInEnvironmentFile(
            $this->generateRandomKey()
        );
        $this->info('Done!');

        $this->warn('Setting up jwt tokens secret');
        $this->call('jwt:secret', [
            '--force' => true,
        ]);
        $this->info('Done!');

        $this->warn('Running migrations');
        $this->call('migrate', ['--force' => true]);
        $this->info('Done!');
    }

    /**
     * Set the application key in the environment file.
     *
     * @param string $key
     *
     * @return void
     */
    protected function setKeyInEnvironmentFile($key): void
    {
        file_put_contents($this->getEnvironmentFilePath(), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY=' . $key,
            file_get_contents($this->getEnvironmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('=' . $this->laravel['config']['app.key'], '/');

        return "/^APP_KEY{$escaped}/m";
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey(): string
    {
        return 'base64:' . base64_encode(
                Encrypter::generateKey($this->laravel['config']['app.cipher'])
            );
    }

    /**
     * get environemt file path
     *
     * @return string
     */
    private function getEnvironmentFilePath(): string
    {
        return base_path(DIRECTORY_SEPARATOR . '.env');
    }

    /**
     * get example environment file path
     *
     * @return string
     */
    private function getExampleEnvironmentFilePath(): string
    {
        return base_path(DIRECTORY_SEPARATOR . '.env.example');
    }
}
