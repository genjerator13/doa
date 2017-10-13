<?php

namespace Numa\CCCAdminBundle\Command;

use Numa\CCCAdminBundle\Entity\EmailLog;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;

class EmailSendingCommand extends ContainerAwareCommand
{

    protected $commandLog;

    //const subject = "Custom Courier Electronic Billing Notification";
    const subject = "CORRECT BILLING FOR NOV 16 to 30, 2016";

    protected function configure()
    {
        //php app/console numa:DOA:emails
        $this
            ->setName('numa:CCC:emails')
            ->setDescription('Send Emails')
            ->addArgument('action', InputArgument::REQUIRED, 'Action')
            ->addArgument('batchid', InputArgument::OPTIONAL, 'Batch ID')
            ->addArgument('sending', InputArgument::OPTIONAL, 'sending');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $logger = $this->getContainer()->get('logger');
        $action = $input->getArgument('action');
        $batchid = $input->getArgument('batchid');
        $sending = $input->getArgument('sending');


        if ($action == 'generateReports') {
            $logger->warning("STARTING generate reports");
            $this->generateReports($batchid);
            $this->generateEmails($input, $batchid);
            if ($sending == 1) {
                $this->sendAllEmails($input, $batchid);
            }
            die();
        } elseif ($action == 'sendEmailsNoAttachment') {
            $logger->warning("STARTING sendEmailsNoAttachment".$batchid);
            $this->sendEmailsNoAttachment($input, $batchid);
            die();
        } elseif ($action == 'sendEmailsWithAttachment') {
            $logger->warning("STARTING sendEmailsWithAttachment");
            $this->sendEmailsWithAttachment($input, true, $batchid);
            die();
        } elseif ($action == 'sendAllEmails') {
            $logger->warning("STARTING sendAllEmails");
            $this->sendAllEmails($input, $batchid);
            die();
        } elseif ($action == 'generateEmails') {
            $logger->warning("STARTING generateEmails");
            $this->generateEmails($input, $batchid);
            die();
        }
    }

    public function sendEmailsNoAttachment($input, $batchid)
    {

        $logger = $this->getContainer()->get('logger');
        $limit = 50;

        $em = $this->getContainer()->get('doctrine')->getManager();
        $logger->warning("inside sendEmailsNoAttachment");
        $countEmailsNoAttachment = $em->getRepository('NumaCCCAdminBundle:Email')->countNotSendEmails(false, $batchid);
        $logger->warning("COUNT sendEmailsNoAttachment " . $countEmailsNoAttachment);
        $ok = true;
        if ($countEmailsNoAttachment > 0) {
            $emailBody = $em->getRepository('NumaCCCAdminBundle:Settings')->findOneBy(array('name' => 'email_template'));

            $emailFrom = $this->getContainer()->getParameter('email_from');
            $action = $input->getArgument('action');
            $mailer = $this->getContainer()->get('mailer');
            $logger->warning("sendEmailsNoAttachment createing command log" . $countEmailsNoAttachment);
            $commandName = "Numa:emails sendEmailsNoAttachment ".$batchid;
            $this->commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();
            $this->commandLog->setCommand($commandName);
            $this->commandLog->setStartedAt(new \DateTime());
            $this->commandLog->setStatus('started');
            $this->commandLog->setCategory('email');
            $this->commandLog->setTotalProbills($batchid);
            $this->commandLog->setCurrentProbill(2);
            $this->commandLog->setTotal($countEmailsNoAttachment);
            $em->persist($this->commandLog);
            $em->flush();
            $logger->warning("sendEmailsNoAttachment flush command log" . $countEmailsNoAttachment);


            $current = 0;
            while ($emails = $em->getRepository('NumaCCCAdminBundle:Email')->getNotSendEmails($limit, false, $batchid)) {
                $logger->warning("sendEmailsNoAttachment getNotSendEmails inside while loop ");
                $current = ($current + $limit > $countEmailsNoAttachment) ? $countEmailsNoAttachment : ($current + $limit);

                $logger->warning("sendEmailsNoAttachment current $current");
                $message = \Swift_Message::newInstance()
                    ->setFrom($emailFrom)
                    //->setTo('e.medjesi@gmail.com')
                    ->setBody($emailBody->getValue());
                foreach ($emails as $email) {
                    //dump($email->getEmailTo());
                    $message->addBcc($email->getEmailTo());
                    $message->setSubject($email->getSubject());
                    $attachment = $email->getAttachment();
                    if (!empty($attachment)) {
                        $message->attach(Swift_Attachment::fromPath($attachment));
                    }
                    $email->setStatus('sent');
                    $email->setEndedAt(new \DateTime());
                    $logger->warning("sendEmailsNoAttachment EMAIL add BCC  " . $email->getEmailTo());

                }
                $logger->warning("sendEmailsNoAttachment EMAIL SENDING " . $email->getEmailTo());
                $ok = $this->getContainer()->get('mailer')->send($message);

                ///make a email log
                $emailLog = new EmailLog();
                $emailLog->setEmail($message);
                $em->persist($emailLog);


                //$testHtml = $this->getContainer()->get('Numa.Controiller.Reports')->renderSwiftMessage($message);
                //dump($testHtml);
                if ($ok) {
                    $this->commandLog->setCurrent($current);
                    $this->commandLog->setEndedAt(new \DateTime());
                    $this->commandLog->setStatus('ended');
                    $em->flush();
                    $logger->warning("sendEmailsNoAttachment END successfully  ");
                }else{
                    $logger->warning("sendEmailsNoAttachment END NOT successfully  ");
                }

            }
        }

    }

    public function sendEmailsWithAttachment($input, $attachment, $batchid)
    {
        $logger = $this->getContainer()->get('logger');
        $limit = 10;
        $logger->warning("inside sendEmailsWithAttachment".$batchid);
        if ($attachment) {
            $commandName = "Numa:emails sendEmailsWithAttachment".$batchid;
        } else {
            $commandName = "Numa:emails sendEmailsWithNOAttachment".$batchid;
        }
        $em = $this->getContainer()->get('doctrine')->getManager();

        $emailBody = $em->getRepository('NumaCCCAdminBundle:Settings')->findOneBy(array('name' => 'email_template'));
        $emailFrom = $this->getContainer()->getParameter('email_from');

        $countEmailsWithAttachment = $em->getRepository('NumaCCCAdminBundle:Email')->countNotSendEmails($attachment,$batchid);
        $logger->warning("COUNT countEmailsWithAttachment " . $countEmailsWithAttachment);




        $logger->warning("COUNT sendEmailsNoAttachment " . $countEmailsWithAttachment);
        $current = 0;
        if ($countEmailsWithAttachment > 0) {
            $this->commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();

//            $action = $input->getArgument('action');
//            $mailer = $this->getContainer()->get('mailer');

            $this->commandLog->setCommand($commandName);
            $this->commandLog->setStartedAt(new \DateTime());
            $this->commandLog->setStatus('started');
            $this->commandLog->setCategory('email');
            $this->commandLog->setTotal($countEmailsWithAttachment);
            $this->commandLog->setTotalProbills($batchid);
            $this->commandLog->setCurrentProbill(3);//code for attacment need for progress
            $em->persist($this->commandLog);
            $em->flush();
            $logger->warning("countEmailsWithAttachment COMMAND LOG STARTED");

            while ($emails = $em->getRepository('NumaCCCAdminBundle:Email')->getNotSendEmails($limit, $attachment,$batchid)) {
                $logger->warning("countEmailsWithAttachment inside WHILE LOOP getNotSendEmails");

                foreach ($emails as $email) {
                    $current++;
                    $logger->warning("sendEmailsNoAttachment inside EMAILS LOOP ".$current);
                    $message = \Swift_Message::newInstance()
                        ->setSubject($email->getSubject())
                        ->setFrom($emailFrom)
                        //->setTo('e.medjesi@gmail.com') //
                        ->setTo($email->getEmailTo())
                        ->setBody($emailBody->getValue());
                    $attachment = $email->getAttachment();
                    if (!empty($attachment)) {
                        $attachments = explode(";", $attachment);
                        foreach ($attachments as $attachment) {
                            $message->attach(\Swift_Attachment::fromPath($attachment));
                        }
                    }

                    $logger->warning("sendEmailsNoAttachment before email sent ".$email->getEmailTo());
                    $ok = $this->getContainer()->get('mailer')->send($message);
                    $logger->warning("sendEmailsNoAttachment after email sent ".$email->getEmailTo());
                    ///make a email log
                    $logger->warning("sendEmailsNoAttachment making email log ".$email->getEmailTo());
                    $emailLog = new EmailLog();
                    $emailLog->setEmail($message);
                    $emailLog->setBatchId($batchid);
                    $emailLog->getStatus("ERROR");
                    if($ok){
                        $emailLog->setStatus("SUCCESS");
                    }
                    $em->persist($emailLog);

                    $logger->warning("sendEmailsNoAttachment SEND EMAIL ATTACHMENT ".$email->getEmailTo());
                    //$testHtml = $this->getContainer()->get('Numa.Controiller.Reports')->renderSwiftMessage($message, $attachment);
                    //dump($testHtml);
                    if ($ok) {
                        $email->setStatus('sent');
                        $email->setEndedAt(new \DateTime());
                        $this->commandLog->setCurrent($current);
                        $em->flush();

                        $logger->warning("sendEmailsNoAttachment SEND EMAIL ATTACHMENT SUCCESS before sleep 30 after email status sent flushed ".$email->getEmailTo());
                        //sleep(30);
                        $logger->warning("sendEmailsNoAttachment SEND EMAIL ATTACHMENT SUCCESS ".$email->getEmailTo());
                    }else{
                        $logger->error("sendEmailsNoAttachment SEND EMAIL ATTACHMENT ERROR ".$email->getEmailTo());
                    }
                }
            }
            $this->commandLog->setEndedAt(new \DateTime());
            $this->commandLog->setStatus('ended');
            $em->flush();
            $logger->warning("sendEmailsNoAttachment END ");
        }

        //die();
    }

    public function sendAllEmails($input, $batchid)
    {
        $this->sendEmailsNoAttachment($input, $batchid);
        $this->sendEmailsWithAttachment($input, true, $batchid);
    }

    public function generateReports($batch_id)
    {
        //get all the customers from the batch which has send email yes
        $logger = $this->getContainer()->get('logger');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();;
        $em->getRepository('NumaCCCAdminBundle:CommandLog')->deleteProgressLog($batch_id);
        $customerSendmailYes = $em->getRepository('NumaCCCAdminBundle:Customers')->findSendYesEmailCustomers();

        $emails = array();
        //dump("customers fetched" . count($customerSendmailYes));
        $commandName = "numa:emails generateReports " . $batch_id . ' ';
        $current = 0;
        $this->commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();
        $this->commandLog->setCurrent($current);

        $this->commandLog->setTotal(count($customerSendmailYes));
        $this->commandLog->setStartedAt(new \DateTime());
        $this->commandLog->setStatus('started');
        $this->commandLog->setCategory('email');
        $this->commandLog->setTotalProbills($batch_id);
        $this->commandLog->setCurrentProbill(0);
        $this->commandLog->setCommand($commandName);
        $em->persist($this->commandLog);
        $em->flush();
        $text = "";
        $logger->warning("generateReports");
        foreach ($customerSendmailYes as $customer) {
            $current++;
            $progressText = "proccessing: " . $customer->getCustcode();
            $logger->warning($progressText);

            $text = $text . $progressText + "<br>/n";
            //dump($progressText);
            //$this->commandLog->setFullDetails();
            if (!$customer->getCustomerEmails()->isEmpty()) {

                foreach ($customer->getCustomerEmails() as $email) {
                    $progressText = "adding email: " . $email->getEmail();
                    $logger->warning($progressText);
                    $text = $text . $progressText . "<br>/n";;
                    //dump($progressText);
                    $temp = array();
                    $temp['email'] = $email->getEmail();
                    $temp['customer'] = $customer;

                    if ($email->getSelected()) {
                        $progressText = "generating  Attachment for the email: " . $email->getEmail();
                        $text = $text . $progressText . "<br>/n";
                        //dump($progressText);

                        $this->getContainer()->get("Numa.Controiller.Reports")->zipAll($batch_id, $customer->getId());
                        $progressText = "path to the attachment: " . $this->getContainer()->get("Numa.Controiller.Reports")->getZipPath($batch_id, $customer->getCustcode());
                        $text = $text . $progressText . "<br>/n";
                        //dump($progressText);
                        $logger->warning($progressText);
                        $xls = $this->getContainer()->get("Numa.Controiller.Reports")->getReportXLS($batch_id, $customer->getCustcode());
                        $pdf = $this->getContainer()->get("Numa.Controiller.Reports")->getReportPDF($batch_id, $customer->getCustcode());
                        $invoice = $this->getContainer()->get("Numa.Controiller.Reports")->getInvoiceReport($batch_id, $customer->getCustcode());

                        $newsletter = $this->getContainer()->get("Numa.Controiller.Reports")->getNewsletterFile($batch_id);
                        if (file_exists($xls)) {
                            $temp['attachment'][] = $xls;
                        }
                        if (file_exists($pdf)) {
                            $temp['attachment'][] = $pdf;
                        }
                        if (file_exists($invoice)) {
                            //dump($invoice);die();
                            $temp['attachment'][] = $invoice;
                        }
                        if (file_exists($newsletter)) {
                            $temp['attachment'][] = $newsletter;
                        }

                        $progressText = "path to the attachment: " . $this->getContainer()->get("Numa.Controiller.Reports")->getReportXLS($batch_id, $customer->getCustcode());
                        $text = $text . $progressText . "<br>/n";
                        $logger->warning($progressText);
                    }

                    $this->commandLog->setCurrent($current);
                    $this->commandLog->setFullDetails($text);

                    $emails[] = $temp;
                }
            }

//            if ($current % 50 == 0) {
            $query = "update command_log set current=$current where id=" . $this->commandLog->getId();
            $stmt = $em->getConnection()->prepare($query);
            $stmt->execute();


//            }
        }
        $em->flush();
        //$template = $em->getRepository('NumaCCCAdminBundle:Settings')->findOneBy(array('name' => 'email_template'));
        $em->getRepository('NumaCCCAdminBundle:Email')->deleteByBatch($batch_id);
        $progressText = "creating email buffer in email dbtable:count: " . count($emails);
        $text = $text + $progressText + "<br>/n";


//        //emails
//
//        foreach ($emails as $email) {
//
//            $emailEntity = new \Numa\CCCAdminBundle\Entity\Email();
//            $emailEntity->setBatchId($batch_id);
//            $emailEntity->setSubject(self::subject);
//            $emailEntity->setBody($template->getValue());
//            $emailEntity->setEmailFrom($this->getContainer()->getParameter('email_from'));
//            $emailEntity->setEmailTo($email['email']);
//            $emailEntity->setStatus('notsend');
//            $emailEntity->setCustomers($email['customer']);
//            if (!empty($email['attachment'])) {
//                $attachment = implode(";", $email['attachment']);
//                $emailEntity->setAttachment($attachment);
//            }
//
//            $em->persist($emailEntity);
//        }
        $this->commandLog->setEndedAt(new \DateTime());
        $this->commandLog->setStatus('ended');
        $em->flush();
    }

    public function generateEmails($input, $batch_id)
    {
        $logger = $this->getContainer()->get('logger');
        $em = $this->getContainer()->get('doctrine')->getEntityManager();;
        $customerSendmailYes = $em->getRepository('NumaCCCAdminBundle:Customers')->findSendYesEmailCustomers();
        $emails = array();
        //dump("customers fetched" . count($customerSendmailYes));
        $commandName = "numa:emails generateEmails " . $batch_id . ' ';
        $current = 0;
        $this->commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();
        $this->commandLog->setCurrent($current);

        $this->commandLog->setTotal(count($customerSendmailYes));
        $this->commandLog->setStartedAt(new \DateTime());
        $this->commandLog->setStatus('started');
        $this->commandLog->setCategory('email');
        $this->commandLog->setTotalProbills($batch_id);
        $this->commandLog->setCurrentProbill(1); //code for emails generate need for progress bar
        $this->commandLog->setCommand($commandName);
        $em->persist($this->commandLog);
        $em->flush();
        $text = "";
        $logger->warning("generateReports");

        $template = $em->getRepository('NumaCCCAdminBundle:Settings')->getValue('email_template');
        $emailSubject = $em->getRepository('NumaCCCAdminBundle:Settings')->getValue('email_subject');

        $em->getRepository('NumaCCCAdminBundle:Email')->deleteByBatch($batch_id);

        $progressText = "creating email buffer in email dbtable:count: " . count($emails);
        $text = $text + $progressText + "<br>/n";

        foreach ($customerSendmailYes as $customer) {
            $current++;
            $progressText = "proccessing: " . $customer->getCustcode();
            $logger->warning($progressText);

            $text = $text . $progressText + "<br>/n";
            //dump($progressText);
            //$this->commandLog-

            $this->commandLog->setCurrent($current);

            if (!$customer->getCustomerEmails()->isEmpty()) {
                $emails = $customer->getCustomerEmails();
                foreach ($emails as $email) {
                    $emailEntity = new \Numa\CCCAdminBundle\Entity\Email();
                    if ($email->getSelected()) {
                        $temp = array();
                        $xls = $this->getContainer()->get("Numa.Controiller.Reports")->getReportXLS($batch_id, $customer->getCustcode());
                        $pdf = $this->getContainer()->get("Numa.Controiller.Reports")->getReportPDF($batch_id, $customer->getCustcode());
                        $invoice = $this->getContainer()->get("Numa.Controiller.Reports")->getInvoiceReport($batch_id, $customer->getCustcode());

                        $newsletter = $this->getContainer()->get("Numa.Controiller.Reports")->getNewsletterFile($batch_id);
                        if (file_exists($xls)) {
                            $temp['attachment'][] = $xls;
                        }
                        if (file_exists($pdf)) {
                            $temp['attachment'][] = $pdf;
                        }
                        if (file_exists($invoice)) {
                            //dump($invoice);die();
                            $temp['attachment'][] = $invoice;
                        }
                        if (file_exists($newsletter)) {
                            $temp['attachment'][] = $newsletter;
                        }

                        $progressText = "path to the attachment: " . $this->getContainer()->get("Numa.Controiller.Reports")->getReportXLS($batch_id, $customer->getCustcode());
                        $text = $text . $progressText . "<br>/n";
                        $logger->warning($progressText);
                        $attachment = implode(";", $temp['attachment']);
                        $emailEntity->setAttachment($attachment);
                    }

                    $emailEntity->setBatchId($batch_id);
                    $emailEntity->setSubject($emailSubject);
                    $emailEntity->setBody($template);
                    $emailEntity->setEmailFrom($this->getContainer()->getParameter('email_from'));
                    $emailEntity->setEmailTo($email->getEmail());
                    $emailEntity->setStatus('notsend');
                    $emailEntity->setCustomers($email->getCustomers());

                    $progressText = "email for: " . $customer->getCustcode();
                    $logger->warning($progressText);
                    $em->persist($emailEntity);
                }
            }
            $em->flush();
        }
        $this->commandLog->setEndedAt(new \DateTime());
        $this->commandLog->setStatus('ended');
        $em->flush();
    }

}
