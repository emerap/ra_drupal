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
 * Class RaFormatCommand.
 *
 * @package Drupal\ra_drupal
 */
class RaFormatCommand extends GeneratorCommand {

  use ModuleTrait;
  use ConfirmationTrait;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('generate:plugin:ra:format')
      ->setDescription($this->trans('command.generate.plugin.ra.format.help'))
      ->addOption('module', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.format.module.help'))
      ->addOption('id', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.format.id.help'))
      ->addOption('label', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.format.label.help'))
      ->addOption('description', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.format.description.help'))
      ->addOption('mime_type', '', InputOption::VALUE_REQUIRED, $this->trans('command.generate.plugin.ra.format.mime_type.help'));
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
      $id = $io->ask($this->trans('command.generate.plugin.ra.format.id.description'), '');
      $input->setOption('id', $id);
    }

    $label = $input->getOption('label');
    if (!$label) {
      $label = $io->ask($this->trans('command.generate.plugin.ra.format.label.description'), '');
      $input->setOption('label', $label);
    }

    $description = $input->getOption('description');
    if (!$description) {
      $description = $io->ask($this->trans('command.generate.plugin.ra.format.description.description'), 'Format description goes here');
      $input->setOption('description', $description);
    }

    $mime_type = $input->getOption('mime_type');
    if (!$mime_type) {
      $mime_type = $io->ask($this->trans('command.generate.plugin.ra.format.mime_type.description'), 'text/plain');
      $input->setOption('mime_type', $mime_type);
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
    $mime_type = $input->getOption('mime_type');

    $yes = $input->hasOption('yes') ? $input->getOption('yes') : FALSE;
    if (!$this->confirmGeneration($io, $yes)) {
      return;
    }

    $this->getGenerator()->generate($module, $id, $description, $label, $mime_type);

  }

  protected function createGenerator() {
    return new RaFormatGenerator();
  }
}
