<?php

use Core\Foundation\Database\Database;

final class MailSentMigration extends Database
{
    public function up()
    {
        $this->schema->create('mail_sent', function(Illuminate\Database\Schema\Blueprint $table){
            $table->id()->unsigned();
            $table->string('sender', 100);
            $table->string('receiver', 100);
            $table->string('title', 100);
            $table->string('message', 255);
            $table->enum('status', ['failed', 'processing', 'success'])->default('processing');
            $table->integer('sent_at')->unsigned()->default(0);
            $table->string('exception', 255);
            
            $table->timestamps();
        });
    }
    public function down()
    {
        $this->schema->drop('mail_sent');
    }
}
