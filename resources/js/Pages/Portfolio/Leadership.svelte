<script>
    import Navbar from '../../components/layout/Navbar.svelte';
    import Footer from '../../components/layout/Footer.svelte';

    let { profile } = $props();

    const navLinks = [
        { href: '/#home', label: 'Home' },
        { href: '/#about', label: 'About' },
        { href: '/#skills', label: 'Skills' },
        { href: '/#projects', label: 'Projects' },
        { href: '/leadership', label: 'Leadership' },
        { href: '/#achievements', label: 'Achievements' },
    ];

    const entries = [
        {
            date: '2025-2026',
            short: 'GDGOC-UIC',
            role: 'Vice Mayor',
            title: 'Google Developer Groups on Campus - UIC',
            logo: '/assets/images/gdglogo.png',
            align: 'left',
            logoSide: 'right',
            points: [
                'Co-led planning and execution of seminars and workshops with the club lead.',
                'Prepared activity plans, budget requests, and liquidation documentation.',
                'Conducted GDGOC-UIC InfoSession for membership and program orientation.',
                'Collaborated with DICE, USEP-DSC, UP SPARCS, and SPACE Davao.',
            ],
        },
        {
            date: '2023-2024',
            short: 'VIBE',
            role: 'Club Mayor',
            title: 'Virtual Initiative for Building Engagement - UIC',
            logo: '/assets/images/vibelogo.png',
            align: 'right',
            logoSide: 'left',
            points: [
                'Facilitated student development seminars and engagement activities.',
                'Led planning and coordination for writing and filmmaking workshops.',
                'Helped strengthen creative and communication skills in the student community.',
            ],
        },
        {
            date: '2023-2024',
            short: 'CCS',
            role: 'UIC-CCS Leader / Spearheader',
            title: 'National Service Training Program-CWTS',
            logo: '/assets/images/ccslogo.png',
            align: 'left',
            logoSide: 'right',
            points: [
                'Designed and facilitated DIGISKWELA digital literacy and game development workshops.',
                'Coordinated responsible digital citizenship seminars for student and community participants.',
                'Spearheaded extension projects with CCS and partner student organizations.',
            ],
        },
    ];

</script>

<svelte:head>
    <title>Leadership | Lemuel Ope\u00f1a</title>
</svelte:head>

<div class="min-h-screen text-[var(--color-text)]">
    <Navbar links={navLinks} />

    <main class="relative overflow-hidden pt-24 md:pt-28">
        <div class="section-grid-zoom" aria-hidden="true"></div>

        {#each entries as entry}
            <section class="dashboard-grid" class:is-right={entry.align === 'right'} class:is-left={entry.align !== 'right'}>
                <div class={`details-wrap ${entry.align === 'right' ? 'details-right' : 'details-left'}`}>
                    {#if entry.short}
                        <div class="short-stack">
                            <div class="short-mark">{entry.short}</div>
                        </div>
                    {/if}
                    <h2 class="role-title">{entry.role}</h2>
                    <p class="org-name">{entry.title}</p>
                    <div class="accent-line"></div>

                    <ul class="point-list">
                        {#each entry.points as point}
                            <li>{point}</li>
                        {/each}
                    </ul>
                </div>

                <div class={`logo-half ${entry.logoSide === 'left' ? 'logo-left' : 'logo-right'}`} aria-hidden="true">
                    <img src={entry.logo} alt="" loading="lazy" />
                </div>
            </section>
        {/each}
    </main>

    <Footer links={navLinks} {profile} />
</div>

<style>
    .dashboard-grid {
        position: relative;
        min-height: 72vh;
        display: grid;
        align-items: center;
        overflow: hidden;
        grid-template-columns: 1fr;
        width: 100%;
        padding: 2rem 1rem;
    }

    .details-wrap {
        position: relative;
        z-index: 3;
        width: min(100%, 1220px);
        padding-top: 1.2rem;
        padding-bottom: 1.2rem;
    }

    .details-left {
        margin-left: 5vw;
        margin-right: auto;
        padding-left: 0;
        padding-right: 24vw;
    }

    .details-right {
        margin-left: auto;
        margin-right: 5vw;
        padding-left: 24vw;
        padding-right: 0;
    }

    .short-stack {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: fit-content;
    }

    .short-mark {
        font-family: var(--font-sans);
        font-kerning: none;
        color: var(--color-warm);
        font-size: clamp(4.5rem, 11vw, 8rem);
        font-weight: 800;
        line-height: 0.95;
        margin: 0;
        letter-spacing: 0;
        display: block;
        width: max-content;
    }

    .role-title {
        margin: 0.45rem 0 0;
        font-size: clamp(1.35rem, 3vw, 2.1rem);
        font-weight: 700;
        color: var(--color-text);
    }

    .org-name {
        margin: 0.4rem 0 0;
        font-size: clamp(1rem, 1.8vw, 1.36rem);
        color: var(--color-muted);
        font-weight: 600;
    }

    .accent-line {
        margin: 1rem 0 1.1rem;
        width: 2.6rem;
        height: 0.22rem;
        border-radius: 999px;
        background: var(--color-warm);
    }

    .point-list {
        margin: 0;
        padding-left: 0;
        display: grid;
        gap: 0.55rem;
        color: var(--color-muted);
        font-size: clamp(0.92rem, 1.5vw, 1.15rem);
        list-style: none;
    }

    .logo-half {
        --logo-width: min(40vw, 520px);
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: var(--logo-width);
        pointer-events: none;
        opacity: 0.42;
        filter: saturate(0.9);
        z-index: 1;
    }

    .logo-right {
        right: calc(var(--logo-width) * -0.5);
    }

    .logo-left {
        left: calc(var(--logo-width) * -0.5);
    }

    .logo-half img {
        width: 100%;
        height: auto;
        display: block;
    }

    @media (max-width: 900px) {
        .dashboard-grid {
            min-height: 68vh;
            padding: 1.35rem 0.9rem 2.2rem;
        }

        .logo-half {
            --logo-width: min(62vw, 360px);
            width: var(--logo-width);
            opacity: 0.34;
        }

        .details-wrap {
            margin-left: auto;
            margin-right: auto;
            padding: 0.8rem 0.3rem;
        }
    }
</style>
