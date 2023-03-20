<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class SendChatGpt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:send-gpt-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->chat();
    }

    private function test()
    {
        $result = OpenAI::models()->retrieve('text-davinci-003');

        dump($result->toArray());
    }

    private function chat()
    {
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => '帮我做一份真皮包包的销售的商业计划书',
            'max_tokens' => 2000,
            //'n' => 3
        ]);

        echo $result['choices'][0]['text'];
        //dump($result);
    }

    private function image()
    {
        $response = OpenAI::images()->create([
            'prompt' => "老板姓刘，主要经营头层牛皮，帮我制作一个logo",
            'n' => 1,
            'size' => '512x512',
            'response_format' => 'url',
        ]);

        dump($response->toArray());
    }
}
