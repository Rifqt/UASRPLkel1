<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan Masyarakat</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg,#007bff 0%, #007bff 100%);
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .hero-section {
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .stats-cards {
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .border-left-info {
            border-left: 4px solid var(--info-color) !important;
        }

        .border-left-success {
            border-left: 4px solid var(--success-color) !important;
        }

        .border-left-warning {
            border-left: 4px solid var(--warning-color) !important;
        }

        .border-bottom-info {
            border-bottom: 4px solid var(--info-color) !important;
        }

        .border-bottom-success {
            border-bottom: 4px solid var(--success-color) !important;
        }

        .border-bottom-warning {
            border-bottom: 4px solid var(--warning-color) !important;
        }

        .feature-section {
            padding: 80px 0;
        }

        .feature-img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }

        .testimonial-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .testimonial-card {
            height: 100%;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .info-section {
            padding: 80px 0;
        }

        .footer {
            background: #343a40;
            color: white;
            padding: 30px 0;
        }

        .btn {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .rounded-section {
            border-bottom-left-radius: 100px;
            border-bottom-right-radius: 100px;
        }

        /* Logo styling */
        .logo-pemalang {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 60vh;
                padding: 50px 0;
            }
            
            .hero-section h1 {
                font-size: 1.8rem;
            }
            
            .stats-cards {
                margin-top: -40px;
            }
            
            .feature-section {
                padding: 50px 0;
            }
            
            .feature-section .row > div {
                margin-bottom: 30px;
            }
            
            .testimonial-section {
                padding: 50px 0;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .logo-pemalang {
                width: 40px;
                height: 40px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease forwards;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3 shadow fixed-top">
        <div class="container" data-aos="fade-down">
            <a class="navbar-brand" href="#">
               <img src="../../assets/img/pm.png" width="100" alt><h1>
                <b>Pemalang Juara</b>
               </h1>
                                                                                          
    </style>

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav">
                    <a href="login.php" class="btn btn-light me-3">Login</a>
                    <a href="register.php" class="btn btn-outline-light">Registrasi</a>
                </div>
            </div>
        </div>                                                                                                                                                               
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-primary hero-section rounded-section" style="margin-top: 76px;">
        <div class="container d-flex justify-content-center" data-aos="zoom-in">
            <div class="text-center col-lg-8 text-light hero-content">
                <h1 class="display-4 fw-bold mb-4">Selamat Pagi!</h1>
                <h2 class="h3 mb-4">Selamat Datang Di Website Aduan Masyarakat Pemalang</h2>
                <p class="lead mb-4">
                    Aplikasi Aduan Masyarakat Pemalang hadir sebagai jembatan antara masyarakat dan pemerintah daerah. 
                    Melalui aplikasi ini, Anda dapat dengan mudah menyampaikan keluhan,
                    laporan, maupun saran terkait layanan publik, infrastruktur, kebersihan, 
                    dan hal-hal lain yang perlu perhatian.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="container stats-cards">
        <div class="row">
            <!-- Card Pengaduan -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="500">
                <div class="card border-left-info border-bottom-info shadow-lg h-100 py-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="h5 mb-0 fw-bold text-info">
                                    0 Pengaduan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comment fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Tanggapan -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
                <div class="card border-left-success border-bottom-success shadow-lg h-100 py-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="h5 mb-0 fw-bold text-success">
                                    0 Tanggapan
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Akun Masyarakat -->
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="900">
                <div class="card border-left-warning border-bottom-warning shadow-lg h-100 py-3">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="h5 mb-0 fw-bold text-warning">
                                    0 Akun Masyarakat
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Section -->
    <div class="container">
      <div class="row">
        <div class="col-6" data-aos="fade-right">
          <div class="desc" style="margin-top: 130px;">
            <h4 class="text-justify text-gray-900">Buat laporan, aduan dan keluh kesah anda di website aduan masyarakat ini dan jangan meyebarkan berita hoax!</h4>
          </div>
        </div>
        <div class="col-6">
          <div class="img mt-5 ml-3" data-aos="fade-left">
            <img src="../../assets/img/hoax.png" width="300" alt="">
          </div>
        </div>

        <div class="col-6" style="margin-top: -45px;">
          <div class="img" data-aos="fade-right">
            <img src="../../assets/img/landing2.svg" width="450" alt="">
          </div>
        </div>
        <div class="col-6" style="margin-top: -45px;">
          <div class="desc ml-3" style="margin-top: 130px;" data-aos="fade-left">
            <h4 class="text-justify text-gray-900">Jangan lupa mengirimkan foto anda saat menyampaikan laporan, aduan ataupun keluh kesah anda di web ini.</h4>
          </div>
        </div>

        <div class="col-6" style="margin-top: -45px;">
          <div class="desc" style="margin-top: 130px;" data-aos="fade-right">
            <h4 class="text-justify text-gray-900">Setelah menyapaikan laporan, aduan atau keluh kesah anda dapat menunggu tanggapan dengan santay.</h4>
          </div>
        </div>
        <div class="col-6" style="margin-top: -45px;" data-aos="fade-left">
          <div class="img ml-3">
            <img src="../../assets/img/landing1.svg" width="450" alt="">
          </div>
        </div>
      </div>
    </div>
</div>


    <!-- Info Section -->
    <!-- Info Section -->
<div class="bg-gradient-primary py-5 info-section">
    <div class="container text-center text-light">
        <h2 class="mb-4" data-aos="fade-up">Info Aduan Masyarakat</h2>
        <a href="https://wa.me/6285161076913" target="_blank" class="btn btn-light btn-lg" data-aos="fade-up" data-aos-delay="200">
            <i class="fab fa-whatsapp me-2"></i>Chat Admin
        </a>
    </div>
</div>

    <!-- Testimonial Section -->
    <div class="container testimonial-section">
        <h2 class="text-center text-uppercase text-dark mb-5" data-aos="zoom-in-up">Perangkat Pemerintah</h2>
        <hr class="mb-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm testimonial-card" data-aos="fade-up" data-aos-duration="500">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                              <img src="../../assets/img/oy.png" width="100" height= 100 class="rounded-circle" alt="Profile">                       
                            <div>
                                <h6 class="mb-0">Muhammad Reza, M.Sos</h6>
                                <small class="text-muted">Kepala Dinas</small>
                            </div>
                        </div>
                        <hr>
                        <p class="card-text text-muted">
                           "Dengan hadirnya sistem pengaduan masyarakat ini, kami berkomitmen menghadirkan pelayanan publik yang responsif dan berkualitas. Ini adalah wujud nyata keterbukaan dan akuntabilitas kami sebagai pelayan masyarakat."
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm testimonial-card" data-aos="fade-up" data-aos-duration="700">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="../../assets/img/oy.png" width="100" height= 100 class="rounded-circle" alt="Profile">  
                            <div>
                                <h6 class="mb-0">M. Rizki, S.Si</h6>
                                <small class="text-muted">Sekretaris</small>
                            </div>
                        </div>
                        <hr>
                        <p class="card-text text-muted">
                          "Kami memastikan seluruh proses administratif dalam sistem ini berjalan tertib, efisien, dan terdokumentasi dengan baik, demi mendukung pengambilan keputusan yang cepat dan tepat."
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm testimonial-card" data-aos="fade-up" data-aos-duration="900">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                             <img src="../../assets/img/oy.png" width="100" height= 100 class="rounded-circle" alt="Profile">  
                            <div>
                                <h6 class="mb-0">Layla Dilla</h6>
                                <small class="text-muted">Bendahara</small>
                            </div>
                        </div>
                        <hr>
                        <p class="card-text text-muted">
                         "Setiap pengelolaan anggaran untuk sistem ini kami jaga dengan transparansi dan tanggung jawab, agar setiap rupiah benar-benar memberikan manfaat sebesar-besarnya bagi masyarakat."
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <h6 class="mb-0">Copyright &copy; 2025 Informatika_Sakti. All rights reserved.</h6>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.h5');
            counters.forEach(counter => {
                const target = parseInt(counter.innerText);
                const increment = target / 100;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.innerText = Math.floor(current) + counter.innerText.replace(/\d+/, '');
                }, 20);
            });
        }

        // Trigger counter animation when cards are visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(document.querySelector('.stats-cards'));

        // Dynamic greeting based on time
        function updateGreeting() {
            const now = new Date();
            const hour = now.getHours();
            let greeting;
            
            if (hour < 10) {
                greeting = "Selamat Pagi";
            } else if (hour < 12) {
                greeting = "Selamat Siang";
            } else if (hour < 14) {
                greeting = "Selamat Sore";
            } else {
                greeting = "Selamat Malam";
            }
            
            const greetingElement = document.querySelector('.hero-content h1');
            if (greetingElement) {
                greetingElement.textContent = greeting + "!";
            }
        }

        // Update greeting on page load
        updateGreeting();
    </script>
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                   