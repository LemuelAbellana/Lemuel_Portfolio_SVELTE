<script>
    import { achievements } from '../../lib/achievements';

    let selectedAchievement = $state(null);

    function openImageModal(achievement) {
        selectedAchievement = achievement;
    }

    function closeImageModal() {
        selectedAchievement = null;
    }

    function handleWindowKeydown(event) {
        if (event.key === 'Escape' && selectedAchievement) {
            closeImageModal();
        }
    }
</script>

<svelte:window onkeydown={handleWindowKeydown} />

<svelte:head>
    <title>Achievements Gallery | Lemuel Opeña</title>
</svelte:head>

<main class="min-h-screen text-[var(--color-text)]">
    <section class="mx-auto w-full max-w-7xl px-6 pb-20 pt-16 md:pt-20">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.32em] text-[var(--color-muted)]">Portfolio</p>
                <h1 class="mt-3 text-3xl font-bold text-[var(--color-warm)] md:text-4xl">Achievements Gallery</h1>
                <p class="mt-3 max-w-3xl text-sm text-[var(--color-muted)] md:text-base">
                    A visual collection of scholarships, competitions, trainings, organizations, and leadership milestones.
                </p>
            </div>
            <a href="/#achievements" class="rounded-full border border-[var(--color-border)] px-5 py-2 text-sm font-semibold text-[var(--color-text)] transition hover:border-[var(--color-warm)] hover:text-[var(--color-warm)]">
                Back to Home
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {#each achievements as achievement, index}
                <article class="overflow-hidden rounded-2xl border border-[var(--color-border)] bg-white/[0.04] shadow-[0_16px_40px_rgba(0,0,0,0.18)]">
                    <button
                        type="button"
                        class="image-trigger-button"
                        aria-label={`Open full image for ${achievement.title}`}
                        onclick={() => openImageModal(achievement)}
                    >
                        <img
                            src={achievement.image}
                            alt={achievement.title}
                            class="image-trigger h-56 w-full object-cover object-center"
                            loading="lazy"
                        />
                    </button>
                    <div class="p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[var(--color-warm)]">#{String(index + 1).padStart(2, '0')}</p>
                        <h2 class="mt-2 text-base font-semibold leading-snug text-[var(--color-text)]">{achievement.title}</h2>
                    </div>
                </article>
            {/each}
        </div>
    </section>

    {#if selectedAchievement}
        <div class="image-modal" role="dialog" aria-modal="true" aria-label={selectedAchievement.title} tabindex="-1">
            <button type="button" class="image-modal-backdrop" aria-label="Close image preview" onclick={closeImageModal}></button>
            <div class="image-modal-content">
                <button type="button" class="image-modal-close" aria-label="Close image preview" onclick={closeImageModal}>
                    &times;
                </button>
                <img src={selectedAchievement.image} alt={selectedAchievement.title} class="image-modal-full" />
            </div>
        </div>
    {/if}
</main>

<style>
    .image-trigger-button {
        display: block;
        width: 100%;
        border: 0;
        padding: 0;
        background: transparent;
        text-align: left;
    }

    .image-trigger {
        cursor: zoom-in;
    }

    .image-modal {
        position: fixed;
        inset: 0;
        z-index: 90;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .image-modal-backdrop {
        position: absolute;
        inset: 0;
        border: 0;
        background: rgba(0, 0, 0, 0.78);
        cursor: pointer;
    }

    .image-modal-content {
        position: relative;
        max-height: 94vh;
        max-width: min(95vw, 1200px);
        width: auto;
    }

    .image-modal-full {
        display: block;
        max-height: 94vh;
        max-width: 100%;
        border-radius: 0.8rem;
        object-fit: contain;
        border: 1px solid rgba(255, 255, 255, 0.24);
        box-shadow: 0 22px 70px rgba(0, 0, 0, 0.46);
    }

    .image-modal-close {
        position: absolute;
        right: 0.7rem;
        top: 0.7rem;
        height: 2.1rem;
        width: 2.1rem;
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 9999px;
        color: #fff;
        background: rgba(8, 8, 16, 0.62);
        font-size: 1.3rem;
        line-height: 1;
        cursor: pointer;
    }
</style>
