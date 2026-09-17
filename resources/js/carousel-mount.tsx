import React from 'react';
import { createRoot } from 'react-dom/client';
import { ThreeDPhotoCarousel, CardData } from './components/ui/3d-carousel';

document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('react-gallery-root');
    if (rootElement) {
        const rawData = rootElement.getAttribute('data-cards');
        let cards: CardData[] = [];
        if (rawData) {
            try {
                cards = JSON.parse(rawData);
            } catch (e) {
                console.error("Failed to parse carousel cards", e);
            }
        }
        
        const root = createRoot(rootElement);
        root.render(
            <React.StrictMode>
                <ThreeDPhotoCarousel cardsData={cards} />
            </React.StrictMode>
        );
    }
});
