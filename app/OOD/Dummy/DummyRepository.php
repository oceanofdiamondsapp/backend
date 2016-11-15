<?php

namespace OOD\Dummy;

use Faker\Factory as Faker;
use OOD\JewelryType;
use OOD\Jobs\Job;
use OOD\Message;
use OOD\Quotes\Quote;
use OOD\Status;
use OOD\Tax;
use OOD\Users\Account;
use Hash;

class DummyRepository
{
    /**
     * A faker instance.
     * 
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * Create a new dummy repository instance.
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Generate a user with fake data.
     * 
     * @return OOD\Users\Account
     */
    public function account()
    {
        return new Account([
            'password' => Hash::make('password'),
            'email'    => $this->faker->email,
            'name'     => $this->faker->name,
        ]);
    }

    /**
     * Generate a job with fake data.
     * 
     * @return OOD\Jobs\Job
     */
    public function job()
    {
        $job = new Job([
            'has_unread_messages' => 0,
            'ship_to_state'       => $this->faker->stateAbbr,
            'deadline'            => date('Y-m-d H:i:s', strtotime('+30 days')),
            'nickname'            => implode(' ', $this->faker->words(4)),
            'budget'              => $this->faker->randomNumber(4),
            'carat'               => $this->faker->randomFloat(2, 0, 10),
            'notes'               => $this->faker->sentence,
        ]);

        return $job;
    }

    /**
     * Generate a dummy message.
     * 
     * @return OOD\Message
     */
    public function message()
    {
        return new Message([
            'body' => implode(' ', $this->faker->sentences(2))
        ]);
    }

    /**
     * Get a random account.
     * 
     * @return OOD\Users\Account
     */
    public function randomAccount()
    {
        $accounts = Account::all();

        return $accounts->random();
    }

    /**
     * Get a random job.
     * 
     * @return OOD\Jobs\Job
     */
    public function randomJob()
    {
        $jobs = Job::all();

        return $jobs->random();
    }

    /**
     * Create a dummy quote for the specified job.
     * 
     * @return OOD\Quotes\Quote
     */
    public function quote($job)
    {
        $alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

        $quote_number = 'Q' . $job->job_number . ucfirst($alpha[$job->quotes->count()]);

        $quote = new Quote([
            'stones_description' => $this->faker->sentence(1),
            'metals_description' => $this->faker->sentence(1),
            'setting_details'    => $this->faker->sentence(2),
            'other_details'      => $this->faker->sentence(3),
            'quote_number'       => $quote_number,
            'size_details'       => $this->faker->randomDigitNotNull,
            'description'        => implode(' ', $this->faker->sentences(5)),
            'expires_at'         => date('Y-m-d H:i:s', strtotime('+30 days')),
            'shipping'           => $this->faker->randomFloat(2, 0, 20),
            'price'              => $this->faker->randomFloat(2, 200, 15000),
        ]);

        $quote->job()->associate($job);
        $quote->status()->associate(Status::findOrFail(6));
        $quote->tax()->associate(Tax::findOrFail(2));
        $quote->jewelryType()->associate(JewelryType::findOrFail(rand(1, 7)));

        return $quote;
    }
}
