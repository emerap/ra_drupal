<?php

namespace Drupal\ra_drupal\Command;

use Drupal\Console\Command\ConfirmationTrait;
use Drupal\Console\Command\GeneratorCommand;
use Drupal\Console\Command\ModuleTrait;
use Drupal\Console\Style\DrupalStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RaDefinitionCommand.
 *
 * @package Drupal\ra_drupal
 */
class RaDefinitionCommand extends GeneratorCommand {

  use ModuleTrait;
  use ConfirmationTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('generate:plugin:ra:definition')
      ->setDescription($this->trans('command.generate.plugin.ra.definition.help'))
      ->addOption('module', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.definition.module.help'))
      ->addOption('id', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.definition.id.help'))
      ->addOption('description', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.definition.description.help'));
  }

  protected function interact(InputInterface $input, OutputInterface $output) {

    $io = new DrupalStyle($input, $output);

    $module = $input->getOption('module');
    if (!$module) {
      // @see Drupal\Console\Command\ModuleTrait::moduleQuestion
      $module = $this->moduleQuestion($output);
      $input->setOption('module', $module);
    }

    $id = $input->getOption('id');
    if (!$id) {
      $id = $io->ask($this->trans('command.generate.plugin.ra.definition.id.description'), 'example.method.name');
      $input->setOption('id', $id);
    }

    $description = $input->getOption('description');
    if (!$description) {
      $description = $io->ask($this->trans('command.generate.plugin.ra.definition.description.description'), 'Definition description goes here');
      $input->setOption('description', $description);
    }

  }


  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $module = $input->getOption('module');
    $id = $input->getOption('id');
    $description = $input->getOption('description');

    $yes = $input->hasOption('yes') ? $input->getOption('yes') : FALSE;
    if (!$this->confirmGeneration($io, $yes)) {
      return;
    }

    $this->getGenerator()->generate($module, $id, $description);

  }

  protected function createGenerator() {
    return new RaDefinitionGenerator();
  }
}
