<?php

namespace App\Notifications;

use App\Models\License;
use App\Models\Machine;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ActionsBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;

class LicenseActivated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly License $license, private readonly Machine $machine)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->text(sprintf('License `%s` has been activated.', $this->license->short_code))
            ->headerBlock('License activated')
            ->contextBlock(function (ContextBlock $block) {
                $block->text('*Code*: `'.$this->license->short_code.'`')->markdown();
            })
            ->sectionBlock(function (SectionBlock $block) {
                $block->text('This license has been activated.');
            })
            ->sectionBlock(function (SectionBlock $block) {
                $block->field("*Email:*\n".$this->license->email)->markdown();
                $block->field("*Plan:*\n".$this->license->plan->name)->markdown();
            })
            ->sectionBlock(function (SectionBlock $block) {
                $block->field("*Machine:*\n`".$this->machine->short_fingerprint.'`')->markdown();
                $block->field("*Platform:*\n".$this->machine->platform)->markdown();
            })
            ->sectionBlock(function (SectionBlock $block) {
                $block->text("That's it!");
            })
            ->actionsBlock(function (ActionsBlock $block) {
                $block->button('See details')
                    ->url(route('licenses.show', $this->license));
                $block->button('Modify')
                    ->url(route('licenses.edit', $this->license))
                    ->primary();
            });
    }
}
