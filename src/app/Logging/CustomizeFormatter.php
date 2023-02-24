<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Processor\UidProcessor;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $uidProcessor = new UidProcessor(10);

        // extra.uid のようにドットを入れることで、連想配列の中身を指定できる
        // 第2引数以降に関して、 monolog と laravel のデフォルト値が異なるので laravel に合わせて設定している
        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name% %extra.uid%: %message% %context%\n",
            'Y-m-d H:i:s',
            true,
            true
        );

        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor($uidProcessor);
            $handler->setFormatter($formatter); // フォーマッターを差し替える
        }
    }
}
