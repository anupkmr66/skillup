<?php
$currentUri = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top transition-all" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= url('/') ?>">
            <i class="fas fa-graduation-cap fa-lg me-2"></i>
            <span class="fw-bold fs-4">SkillUp CIMS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('about') ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('courses') ?>">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('verify-certificate') ?>">Verify</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('franchise-inquiry') ?>">Franchise</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3" href="<?= url('contact') ?>">Contact</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-light btn-sm rounded-pill px-4 fw-bold text-primary shadow-sm"
                        href="<?= url('login') ?>">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>