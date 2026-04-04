<script>
    import { onMount } from 'svelte';
    import Navbar from '../../components/layout/Navbar.svelte';
    import Footer from '../../components/layout/Footer.svelte';
    import HeroSection from '../../components/sections/HeroSection.svelte';
    import AboutSection from '../../components/sections/AboutSection.svelte';
    import SkillsSection from '../../components/sections/SkillsSection.svelte';
    import ProjectsSection from '../../components/sections/ProjectsSection.svelte';
    import AchievementsSection from '../../components/sections/AchievementsSection.svelte';

    let { profile } = $props();

    const navLinks = $derived([
        { id: 'home', label: 'Home' },
        { id: 'about', label: 'About' },
        { id: 'skills', label: 'Skills' },
        { id: 'projects', label: 'Projects' },
        { href: '/leadership', label: 'Leadership' },
        { id: 'achievements', label: 'Achievements' },
    ]);

    let loaded = $state(false);

    $effect(() => {
        navLinks.length;
    });

    onMount(() => {
        loaded = true;
    });
</script>

<div class="min-h-screen text-[var(--color-text)]">
    <Navbar links={navLinks} />
    <HeroSection {profile} />
    <AboutSection />
    <SkillsSection />
    <ProjectsSection />
    <AchievementsSection />
    <Footer links={navLinks} {profile} />
</div>
