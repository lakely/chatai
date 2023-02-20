<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{

    public function index(Request $request)
    {
        $prompt = $request->input('prompt');
        if (empty($prompt)) {
            return json_encode([
                'code' => 1,
                'message' => '你好，我是ChatAI，开始和我聊天吧~',
                'data' => []
            ]);
        }

        try {
            $result = OpenAI::completions()->create([
                'model'      => 'text-davinci-003',
                'prompt'     => $prompt,
                'max_tokens' => 2000,
                //'n' => 3
            ]);
        } catch (\Throwable $e) {
            return json_encode([
                'code' => 2,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }

        return json_encode([
            'code' => 0,
            'data' => [
                'text' => $result['choices'][0]['text']
            ]
        ]);
    }

    public function image(Request $request)
    {
        $prompt = $request->input('prompt');
        if (empty($prompt)) {
            return json_encode([
                'code' => 1,
                'message' => '你好，我是ChatAI，开始和我聊天吧~',
                'data' => []
            ]);
        }

        try {
            $response = OpenAI::images()->create([
                'prompt' => $prompt,
                'n' => 1,
                'size' => '512x512',
                'response_format' => 'url',
            ]);
        } catch (\Throwable $e) {
            return json_encode([
                'code' => 2,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }

        $result = $response->toArray();
        return json_encode([
            'code' => 0,
            'data' => $result
        ]);
    }
}
