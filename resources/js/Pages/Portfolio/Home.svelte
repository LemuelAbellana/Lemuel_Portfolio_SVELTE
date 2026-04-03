<script>
    import { onMount } from 'svelte';
    import Navbar from '../../components/layout/Navbar.svelte';
    import Footer from '../../components/layout/Footer.svelte';
    import HeroSection from '../../components/sections/HeroSection.svelte';
    import AboutSection from '../../components/sections/AboutSection.svelte';
    import SkillsSection from '../../components/sections/SkillsSection.svelte';
    import ProjectsSection from '../../components/sections/ProjectsSection.svelte';
    import LeadershipSection from '../../components/sections/LeadershipSection.svelte';
    import AchievementsSection from '../../components/sections/AchievementsSection.svelte';
    import ContactSection from '../../components/sections/ContactSection.svelte';
    import ResumeSection from '../../components/sections/ResumeSection.svelte';

    let { profile, flash = {}, errors = {} } = $props();

    const navLinks = $derived([
        { id: 'home', label: 'Home' },
        { id: 'about', label: 'About' },
        { id: 'skills', label: 'Skills' },
        { id: 'projects', label: 'Projects' },
        { id: 'leadership', label: 'Leadership' },
        { id: 'achievements', label: 'Achievements' },
        { id: 'contact', label: 'Contact' },
        { id: 'resume', label: 'Resume' },
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
    <LeadershipSection />
    <AchievementsSection />
    <ContactSection {profile} {flash} {errors} />
    <ResumeSection {profile} />
    <Footer links={navLinks} {profile} />
</div>
