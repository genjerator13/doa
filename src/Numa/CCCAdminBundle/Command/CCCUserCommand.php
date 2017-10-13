<?php
namespace Numa\CCCAdminBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;
 
class CCCUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        //php app/console numa:DOA:users admin admin
        $this
            ->setName('numa:CCC:users')
            ->setDescription('Add CCC user')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
        ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
 
        $em = $this->getContainer()->get('doctrine')->getManager();
 
        $user = new \Numa\CCCAdminBundle\Entity\Customers();
        //$user->setEmail($email);
        $user->setUsername($username);
        // encode the password
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodedPassword);
        $user->setIsAdmin(1);
        $em->persist($user);
        $em->flush();
 
        $output->writeln(sprintf('Added %s user with password %s', $username, $password));
    }
}
