<?php

/**
 * History_Event_Email_Lender extends History_Event_Email and is used for tracking when an email is sent to a Lender
 *
 * <code>
 * try {
 *
 *     $event = new History_Event_Email_Lender(array(
 *         'subject'   => $mailer->Subject,
 *         'message'   => $mailer->Body,
 *         'sender'    => 1
 *     ), array(
 *         new History_User_Lender(1),
 *         $authuser->getHistoryUser()
 *     ));
 *
 *     $event->save();
 *
 * } catch (Exception $e) {
 *     echo '<p>' . $e->getMessage() . '</p>';
 * }
 * </code>
 *
 * @package History
 */
class History_Event_Email_Lender extends History_Event_Email
{

    /**
     * @see History_Event::getMessage()
     */
    function getMessage(array $options = array())
    {

        // Message View
        $options['view'] = in_array($options['view'], array('system', 'lender', 'agent')) ? $options['view'] : 'system';

        // History Event Users
        foreach ($this->users as $user) {
            $type = get_class($user);
            if ($type == 'History_User_Lender') {
                $lender = $user;
            }
            if ($user->getUser() == $this->getData('sender') && $lender != $user) {
                $sender = $user;
            }
        }

        // If Not Set, Make A Dummy Lender
        if (empty($lender)) {
            $lender = new History_User_Lender(0);
        }

        // Delayed Email was Sent
        $delayed = $this->getData('delayed') ? true : false;

        // Delayed Email to Send Later..
        $timestamp = $this->getData('timestamp') ? $this->getData('timestamp') : false;

        // System History
        if ($options['view'] == 'system') {
            // Delayed Email
            if (!empty($delayed)) {
                if (!empty($sender)) {
                    if (!empty($timestamp)) {
                        return $sender->displayLink() . ' set Delayed Email to send on ' . date('F\, jS Y \a\t g\:ia', $this->getData('timestamp')) . ': ' . $this->getData('subject');
                    } else {
                        return $sender->displayLink() . '\'s Delayed Email sent to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                    }
                } else {
                    if (!empty($timestamp)) {
                        return 'Delayed Email to send on ' . date('F\, jS Y \a\t g\:ia', $this->getData('timestamp')) . ': ' . $this->getData('subject');
                    } else {
                        return 'Delayed Email sent to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                    }
                }

            // Direct Email
            } else {
                if (!empty($sender)) {
                    return $sender->displayLink() . ' sent Email to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                } else {
                    return 'Email Sent to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                }
            }
        }

        // Agent / Lender History
        if (in_array($options['view'], array('agent', 'lender'))) {
            // Is Sender
            $is_sender = ($options['view'] == 'agent' && $options['user'] == $sender->getUser() && $sender->getType() == History_User::TYPE_AGENT) ||
                         ($options['view'] == 'lender' && $options['user'] == $sender->getUser() && $sender->getType() == History_User::TYPE_LENDER);

            // Delayed Email
            if (!empty($delayed)) {
                if (!empty($sender)) {
                    if (!empty($is_sender)) {
                        if (!empty($timestamp)) {
                            return 'Set Delayed Email to send to ' . $lender->displayLink() . ' on ' . date('F\, jS Y \a\t g\:ia', $this->getData('timestamp')) . ': ' . $this->getData('subject');
                        } else {
                            return 'Delayed Email Sent to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                        }
                    } else {
                        if (!empty($timestamp)) {
                            return $sender->displayLink() . ' set Delayed Email to send on ' . date('F\, jS Y \a\t g\:ia', $this->getData('timestamp')) . ': ' . $this->getData('subject');
                        } else {
                            return $sender->displayLink() . '\'s Delayed Email Sent: ' . $this->getData('subject');
                        }
                    }
                } else {
                    if (!empty($timestamp)) {
                        return 'Delayed Email to send on ' . date('F\, jS Y \a\t g\:ia', $this->getData('timestamp')) . ': ' . $this->getData('subject');
                    } else {
                        return 'Delayed Email Sent: ' . $this->getData('subject');
                    }
                }

            // Direct Email
            } else {
                if (!empty($sender)) {
                    if (!empty($is_sender)) {
                        return 'Sent Email to ' . $lender->displayLink() . ': ' . $this->getData('subject');
                    } else {
                        return $sender->displayLink() . ' Sent Email: ' . $this->getData('subject');
                    }
                } else {
                    return 'Email Sent: ' . $this->getData('subject');
                }
            }
        }
    }
}
