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
 * Class RaDataTypeCommand.
 *
 * @package Drupal\ra_drupal
 */
class RaDatatypeCommand extends GeneratorCommand {

  use ModuleTrait;
  use ConfirmationTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('generate:plugin:ra:datatype')
      ->setDescription($this->trans('command.generate.plugin.ra.datatype.help'))
      ->addOption('module', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.datatype.module.help'))
      ->addOption('id', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.datatype.id.help'))
      ->addOption('label', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.datatype.label.help'))
      ->addOption('description', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.datatype.description.help'));
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
      $id = $io->ask($this->trans('command.generate.plugin.ra.datatype.id.description'), '');
      $input->setOption('id', $id);
    }

    $label = $input->getOption('label');
    if (!$label) {
      $label = $io->ask($this->trans('command.generate.plugin.ra.datatype.label.description'), '');
      $input->setOption('label', $label);
    }

    $description = $input->getOption('description');
    if (!$description) {
      $description = $io->ask($this->trans('command.generate.plugin.ra.datatype.description.description'), 'Format description goes here');
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
    $label = $input->getOption('label');

    $yes = $input->hasOption('yes') ? $input->getOption('yes') : FALSE;
    if (!$this->confirmGeneration($io, $yes)) {
      return;
    }

    $this->getGenerator()->generate($module, $id, $description, $label);

  }

  protected function createGenerator() {
    return new RaDatatypeGenerator();
  }
}
