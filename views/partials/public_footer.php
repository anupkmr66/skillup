<!-- Big Footer -->
<footer class="footer-section">
    <div class="container">

        <div class="footer-content pt-5 pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="<?= url('/') ?>">
                                <h2 class="text-white"><i class="fas fa-graduation-cap me-2"></i>SkillUp</h2>
                            </a>
                        </div>
                        <div class="footer-text">
                            <p>SkillUp is a leading Computer Center Management System empowering education institutes
                                with advanced technology solutions. We specialize in franchise management, student
                                certification, and online examinations.</p>
                        </div>
                        <div class="footer-social-icon">
                            <span>Follow us</span>
                            <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                            <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                            <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a>
                            <a href="#"><i class="fab fa-instagram instagram-bg"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Useful Links</h3>
                        </div>
                        <ul>
                            <li><a href="<?= url('/') ?>">Home</a></li>
                            <li><a href="<?= url('about') ?>">About Us</a></li>
                            <li><a href="<?= url('courses') ?>">Our Courses</a></li>
                            <li><a href="<?= url('verify-certificate') ?>">Verify Certificate</a></li>
                            <li><a href="<?= url('franchise-inquiry') ?>">Franchise</a></li>
                            <li><a href="<?= url('contact') ?>">Contact Us</a></li>
                            <li><a href="<?= url('login') ?>">Student Login</a></li>
                            <li><a href="<?= url('login') ?>">Admin Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Subscribe</h3>
                        </div>
                        <div class="footer-text mb-25">
                            <p>Don't miss to subscribe to our new feeds, kindly fill the form below.</p>
                        </div>
                        <div class="subscribe-form">
                            <form action="#">
                                <input type="text" placeholder="Email Address">
                                <button><i class="fab fa-telegram-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 text-center text-lg-start">
                    <div class="copyright-text">
                        <p>Copyright &copy; <?= date('Y') ?>, All Right Reserved <a href="<?= url('/') ?>">SkillUp
                                CIMS</a></p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="<?= url('/') ?>">Home</a></li>
                            <li><a href="<?= url('terms') ?>">Terms</a></li>
                            <li><a href="<?= url('privacy') ?>">Privacy</a></li>
                            <li><a href="<?= url('policy') ?>">Policy</a></li>
                            <li><a href="<?= url('contact') ?>">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>