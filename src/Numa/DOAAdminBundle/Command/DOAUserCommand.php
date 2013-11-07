<?php
namespace Numa\DOAAdminBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;
 
class DOAUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('numa:DOA:users')
            ->setDescription('Add DOA user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
        ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
 
        $em = $this->getContainer()->get('doctrine')->getManager();
 
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($email);
        // encode the password
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodedPassword);
        $em->persist($user);
        $em->flush();
 
        $output->writeln(sprintf('Added %s user with password %s', $email, $password));
    }
}
