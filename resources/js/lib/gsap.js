import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export { gsap, ScrollTrigger };

export const fadeInUp = (targets, overrides = {}) => {
    return gsap.fromTo(
        targets,
        { y: 60, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 0.9,
            ease: 'power3.out',
            stagger: 0.12,
            ...overrides,
        }
    );
};

export const revealOnScroll = (trigger, targets, options = {}) => {
    const start = options.start ?? 'top 80%';
    return ScrollTrigger.create({
        trigger,
        start,
        once: true,
        onEnter: () => {
            fadeInUp(targets, options.animation ?? {});
        },
    });
};
