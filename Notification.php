<?php defined('SYSPATH') or die;

    class Task_Gearman_Email_Notification extends Task_Gearman_Email {

        protected $_task_name = self::GEARMAN_TASK_EMAIL_NOTIFICATION;

        public function _callback() {

            $notification = ORM::factory('Notification',$this->_data['notification_id']);
            if (!$notification->loaded()) {
                throw new Kohana_Exception('Invalid notification id');
            }
            $notification_group = ORM::factory('Notification_Type')->get_notification_group_by_type($notification->type);

            if ($notification_group == 0) {
                throw new Kohana_Exception('Invalid notification group. Notification id = '.$this->_data['notification_id']);
            }

            $notification_obj = Notification::factory($notification->type);

            if (!empty($this->_data['recipients'])) {

                foreach ($this->_data['recipients'] as $recipient) {

                    if ($recipient['notification_group_'.$notification_group] == 1) {

                        $html_message = $notification_obj->build_email($notification,$recipient);

                        if (!$html_message) {
                            throw new Kohana_Exception('No notification html message. Must be sent instant.');
                        }

//                        $to = Kohana::$environment == Kohana::PRODUCTION ? $this->get_to($recipient['email'],$recipient['name']) : $this->get_to('test@dealroom.co','Dr team');

                        $email = $this->compose_email(
                            $html_message,
                            $recipient['email'],
                            $recipient['name'],
                            null,
                            null,
                            $this->get_instant_email_subject($notification_group,'notification',$notification->id, Kohana::$environment == Kohana::PRODUCTION ? true : false),
                            isset($this->_data['tag']) ? $this->_data['tag'] : null
                        );

                        $this->email_send($email);

                    } else {

                        ORM::factory('Notification_Postoned')
                            ->values(array(
                                'item_id' => $notification->id,
                                'item_type' => 'notification',
                                'notification_group' => $notification_group,
                                'notification_group_setting' => $recipient['notification_group_'.$notification_group],
                                'bobject_user_id' => $recipient['bobject_id'],
                            ))->create();

                    }

                }

            }

        }

    }