<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceContainerTest()
    {
        app()->bind('lifeCycleTest', function(){
            return 'ライフサイクルテスト';
        });

        $test = app()->make('lifeCycleTest');

        //サービスコンテナなしのパターン
        //sampleクラスを使う際はmessageのインスタンス化が必要
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        //サービスコンテナapp()ありのパターン
        //サービスコンテナを使用するとnewでインスタンス化が不要となる
        //bindでサービスコンテナに入れる際に名前を決める必要があるので、'sample'とする
        //Sample::classでクラスを紐付けが可能
        app()->bind('sample', Sample::class);

        //サービスコンテナの呼び出し
        //依存しているクラスを同時にインスタンス化してくれるため、newで同時にインスタンス化しなくても使える
        $sample = app()->make('sample');
        $sample->run();

        dd($test, app());
    }
}


class Sample
{
    // __construct(Message $message) の1つ目の変数は使うクラスで、2つ目の変数が Messageをインスタンス化した変数になります。
    // $this->messageは public $message です。(この時点では中身は何もない)
    // $this->message = $message　の時点で、 pubilc $message = Messageのインスタンス になるので、
    // $this->message がインスタンスになり、クラス内の send()が使えるようになる、という流れにはなります。


    public $message;
    //引数にクラスを入れると自動的にインスタンス化する（DIという仕組み）
    public function __construct(Message $message)
    {
        //メッセージクラスがメッセージに入り、メッセージとして使えるようになる
        //sampleクラスだけど、メッセージクラスを指定できるようになる
        $this->message = $message;
    }

    public function run(){
        $this->message->send();
    }
}


class Message
{
    public function send(){
        echo('メッセージ表示');
    }
}

