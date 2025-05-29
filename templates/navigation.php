<nav class="navbar">
    <div class="container">
        <a href="index.php" class="navbar-brand">Cotizaciones Online</a>
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><span class="nav-link">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span></li>
                <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="cotizador.php" class="nav-link">Nueva Cotización</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Cerrar Sesión</a></li>
            <?php else: ?>
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="register.php" class="nav-link">Registro</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>