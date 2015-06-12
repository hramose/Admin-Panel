@extends('adminPanel::layouts.master')

@section('content')
    <div class="starter-template" style="text-align: center;">
        <h1>Bootstrap starter template</h1>

        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a
            mostly barebones HTML document.</p>

    </div>

    <?php $__env->startSection('test_content'); ?>

    <div class="item">Test</div>

    <?php $__env->stopSection(); ?>

@stop