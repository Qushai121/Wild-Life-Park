<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>

<link rel="stylesheet" href="<?= base_url('css/TicketCard.css'); ?>">

<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>



<div class="container">
    <?php foreach ($listTickets as $key => $listTicket) : ?>
        <?= component('LandingPages/CardTicket', $listTicket); ?>
    <?php endforeach; ?>
</div>
<?= $this->endSection('content'); ?>