# Context
I am currently updating my portfolio website. I have a "Skills" section that currently displays my tech stack as static badges in a row. I want to upgrade this UI to an animated, horizontally scrolling carousel (similar to an infinite marquee) to make it more engaging. 

# Objective
Replace the static skills container with an infinite moving carousel that continuously scrolls from right to left. The design should look sleek, modern, and seamless.

# Design & Behavior Requirements
1. **Animation Style:** - Implement an infinite horizontal scroll (marquee effect).
   - The animation must be smooth and use CSS keyframes (e.g., `translateX`).
   - The loop must be completely seamless with no sudden jumps when it resets.
2. **Interactivity:**
   - **Pause on Hover:** The animation should pause when the user hovers over the carousel, allowing them to easily read the skills.
3. **Styling of Badges:**
   - Keep the dark theme aesthetic.
   - Each skill should be encapsulated in a pill or rounded-rectangle badge with a subtle glowing or glowing-border effect.
   - Include the official logo/icon for each skill next to its name.
4. **Layout:**
   - Add a fade-out gradient mask on the left and right edges of the carousel container so the badges look like they are appearing from and disappearing into the background.

# Content (Skills Data)
Please include the following skills in the carousel. (Duplicate this array dynamically or statically to ensure the seamless loop effect covers the full screen width):
- Java
- Python
- JavaScript
- PHP
- Laravel
- React
- Svelte
- Express JS
- MySQL
- Flutter
- NodeJS
- MongoDB

# Technical Implementation Guidelines
- **CSS Keyframes:** Use a `@keyframes scroll` animation that translates the container from `transform: translateX(0)` to `transform: translateX(-50%)` (assuming the content is duplicated once to allow the loop).
- **Responsiveness:** Ensure the carousel works on mobile devices. You may need to adjust the speed or scale of the badges for smaller screens.

Please generate the necessary HTML structure and CSS/Tailwind classes to achieve this exact effect.