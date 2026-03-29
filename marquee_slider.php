<style>
/* Yellow background bar */
.marquee-wrapper {
    width: 100%;
    background: linear-gradient(90deg, #ffc107, #FFAC00, #ffc107);
    overflow: hidden;
    padding: 12px 0;
}

/* Marquee track */
.marquee {
    display: flex;
    width: max-content;
    animation: scroll-left 30s linear infinite;
}

/* Pause on hover */
.marquee-wrapper:hover .marquee {
    animation-play-state: paused;
}

/* Button style */
.menu-btn {
    margin: 0 10px;
    padding: 8px 22px;
    color: #fff;
    font-weight: 700;
    border-radius: 8px;
    text-decoration: none;
    white-space: nowrap;
    font-size: 16px;
}

/* Colors */
.c1 { background:#0d6efd; }
.c2 { background:#198754; }
.c3 { background:#6f42c1; }
.c4 { background:#fd7e14; }
.c5 { background:#dc3545; }
.c6 { background:#0f766e; }
.c7 { background:#0dcaf0; }
.c8 { background:#495057; }

/* Animation */
@keyframes scroll-left {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>

<div class="marquee-wrapper">

    <div class="marquee">

        <!-- MENU (repeat twice for smooth loop) -->
        <a href="javascript:void(0)" class="menu-btn c1">Agriculture</a>
        <a href="javascript:void(0)" class="menu-btn c2">Health</a>
        <a href="javascript:void(0)" class="menu-btn c3">Education</a>
        <a href="javascript:void(0)" class="menu-btn c4">Micro Credit</a>
        <a href="javascript:void(0)" class="menu-btn c5">Income Generation</a>
        <a href="javascript:void(0)" class="menu-btn c6">Sports</a>
        <a href="javascript:void(0)" class="menu-btn c7">Employment Based Programs</a>
        <a href="javascript:void(0)" class="menu-btn c8">Seminar & Workshop</a>
        <a href="javascript:void(0)" class="menu-btn c1">Publicity</a>
        <a href="javascript:void(0)" class="menu-btn c2">Evolution & Research & Training / Free Legal Aid</a>
        <a href="javascript:void(0)" class="menu-btn c3">Old Age Home & Hostel</a>
        <a href="javascript:void(0)" class="menu-btn c4">Handicraft & Handicapped</a>
        <a href="javascript:void(0)" class="menu-btn c5">Pro. Sanitation</a>
        <a href="javascript:void(0)" class="menu-btn c6">Tourism Promotion</a>
        <a href="javascript:void(0)" class="menu-btn c7">Environment Energy</a>
        <a href="javascript:void(0)" class="menu-btn c8">Women Empowerment & Watershed</a>

        <!-- DUPLICATE (for infinite scroll) -->
        <a href="javascript:void(0)" class="menu-btn c1">Agriculture</a>
        <a href="javascript:void(0)" class="menu-btn c2">Health</a>
        <a href="javascript:void(0)" class="menu-btn c3">Education</a>
        <a href="javascript:void(0)" class="menu-btn c4">Micro Credit</a>
        <a href="javascript:void(0)" class="menu-btn c5">Income Generation</a>
        <a href="javascript:void(0)" class="menu-btn c6">Sports</a>
        <a href="javascript:void(0)" class="menu-btn c7">Employment Based Programs</a>
        <a href="javascript:void(0)" class="menu-btn c8">Seminar & Workshop</a>

    </div>

</div>

</body>
</html>