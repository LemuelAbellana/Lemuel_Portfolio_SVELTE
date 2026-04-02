<script>
    import { onDestroy, onMount } from 'svelte';
    import SectionTitle from '../ui/SectionTitle.svelte';
    import ProjectCard from '../ui/ProjectCard.svelte';
    import { revealOnScroll } from '../../lib/gsap';

    let section = $state(null);
    let cardNodes = $state([]);
    let trigger = $state(null);

    const projects = [
        {
            name: 'IP Management System',
            description: 'A PWA built to streamline intellectual property protection application workflows for ITSO at UIC.',
            tags: ['PWA', 'Laravel', 'Software Engineering'],
            role: 'Full-Stack Developer',
            features: ['IP application workflow', 'Status tracking', 'Document handling for submissions'],
            outcome: 'Supported a more efficient and organized IP filing process.',
        },
        {
            name: 'RPIC Research Management',
            description: 'A PWA for research defense scheduling, document storage, and publication/seminar information management.',
            tags: ['PWA', 'MySQL', 'PAASCU Support'],
            role: 'Backend and Database Developer',
            features: ['Defense schedule management', 'Research document repository', 'Information access for seminars/publications'],
            outcome: 'Improved compliance support and organizer efficiency for research activities.',
        },
        {
            name: 'Anime Dojo Game',
            description: 'An interactive gaming PWA integrated with trained AI models to predict outcomes and provide user insights.',
            tags: ['AI', 'JavaScript', 'Node.js'],
            role: 'Game Systems Developer',
            features: ['AI-assisted prediction engine', 'Session-based scoring', 'Interactive gameplay loops'],
            outcome: 'Delivered a more engaging and personalized player experience.',
        },
        {
            name: 'Guide to Loratadine (Allerta)',
            description: 'A mobile application that educates users about Loratadine mechanisms and effects in the body.',
            tags: ['Mobile', 'Health Education', 'IT Elective'],
            role: 'Mobile App Developer',
            features: ['Drug mechanism overview', 'Educational mobile interface', 'Structured health information'],
            outcome: 'Provided a student-focused health learning resource in mobile format.',
        },
        {
            name: 'NeuroZen',
            description: 'A mobile prototype for stress management with a simulated marketplace for wellness products.',
            tags: ['Mobile', 'Prototype', 'Wellness'],
            role: 'Prototype Developer',
            features: ['Stress-management concept screens', 'Simulated product marketplace', 'Mobile-first user journey'],
            outcome: 'Validated a practical concept for wellness-oriented mobile experiences.',
        },
        {
            name: 'TUN-AN Landing Page',
            description: 'A corporate landing page for a Technopreneurship company with an integrated email inquiry workflow.',
            tags: ['Landing Page', 'Email Integration', 'Technopreneurship'],
            role: 'Frontend and Integration Developer',
            features: ['Corporate brand layout', 'Email inquiry handling', 'Customer-service contact flow'],
            outcome: 'Improved customer inquiry handling and online company visibility.',
        },
        {
            name: 'Clinic-Connect',
            description: 'A pediatric care appointment PWA for booking, consultations, and medication purchasing.',
            tags: ['PWA', 'Healthcare', 'Appointments'],
            role: 'Full-Stack Developer',
            features: ['Appointment booking system', 'Consultation queue management', 'Medication catalog and ordering'],
            outcome: 'Centralized pediatric care workflows for patients and clinic staff.',
        },
        {
            name: 'Ayo-ayo AI Green Computing',
            description: 'An AI-integrated mobile app promoting e-waste mitigation through recycle, donate, and sell flows.',
            tags: ['AI', 'Mobile', 'Sustainability'],
            role: 'Mobile and API Integrator',
            features: ['Recycling and donation flows', 'Sell feature for reusable electronics', 'Knowledge-sharing prompts'],
            outcome: 'Encouraged practical e-waste awareness and action through a user-friendly app.',
        },
        {
            name: 'Public Health Research Forum Materials',
            description: 'Designed publication materials for the University of the Immaculate Conception Public Health Research Forum 2024.',
            tags: ['Publication Design', 'Academic Event', '2024'],
            role: 'Publication Designer',
            features: ['Visual communication assets', 'Event publication layout', 'Consistent branding support'],
            outcome: 'Supported event communication and participant engagement.',
        },
        {
            name: 'House Rental System',
            description: 'A personal PWA for rental listing management and tenant tracking.',
            tags: ['PWA', 'Property Management', 'Personal Project'],
            role: 'Full-Stack Developer',
            features: ['Listing and tenant management', 'Rental status dashboard', 'Record maintenance module'],
            outcome: 'Simplified rental operations and reduced manual property tracking tasks.',
        },
        {
            name: 'UIC Digital Christmas Tree',
            description: 'A web application commemorating 2025 university events with interactive ornaments and 2026 resolution sharing.',
            tags: ['Interactive Web App', 'Community', 'Personal Project'],
            role: 'Frontend Developer',
            features: ['Interactive ornament placement', 'Resolution sharing flow', 'Event-themed visual design'],
            outcome: 'Created an engaging and memorable digital year-end experience for users.',
        },
        {
            name: 'Personal Portfolio Website',
            description: 'A personal web application presenting professional background, projects, affiliations, and services.',
            tags: ['Portfolio', 'Svelte', 'Laravel'],
            role: 'Designer and Developer',
            features: ['Project showcase', 'Leadership and achievements timeline', 'Contact and resume sections'],
            outcome: 'Strengthened professional branding for internship and job applications.',
        },
        {
            name: 'NASA Data Weather Forecast App',
            description: 'An AI-integrated mobile app using NASA data to provide weather safety insights for hikers and adventurers.',
            tags: ['AI', 'NASA Data', 'Mobile'],
            role: 'Mobile and AI Integrator',
            features: ['Weather safety insights', 'Adventure-oriented risk prompts', 'Data-driven mobile recommendations'],
            outcome: 'Developed for the NASA Space Apps Challenge 2025 with global challenge context.',
        },
    ];

    $effect(() => {
        projects.length;
    });

    onMount(() => {
        if (!section) return;
        trigger = revealOnScroll(section, cardNodes, { animation: { stagger: 0.14 } });
    });

    onDestroy(() => {
        if (trigger) trigger.kill();
    });
</script>

<section id="projects" class="section-wrap" bind:this={section}>
    <div class="mx-auto w-full max-w-6xl px-6">
        <SectionTitle number="03" title="Projects" subtitle="Academic and personal projects across PWA development, mobile applications, AI integration, design, and community-focused systems." />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            {#each projects as project, i}
                <div bind:this={cardNodes[i]}>
                    <ProjectCard
                        index={i + 1}
                        name={project.name}
                        description={project.description}
                        tags={project.tags}
                        role={project.role}
                        features={project.features}
                        outcome={project.outcome}
                    />
                </div>
            {/each}
        </div>
    </div>
</section>
