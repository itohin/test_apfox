<?php

namespace App\Console\Commands;

use App\Models\Company;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

class CreatePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new company post';

    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companyId = $this->ask('Please enter Company ID?');
        $company = Company::find($companyId);
        if (is_null($company)) {
            $this->error("Company doesn't exists");
            return 0;
        }
        $company->posts()->create([
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph
        ]);
        return 0;
    }
}
