import React from 'react';
import { createRoot } from 'react-dom/client';
import { FaqPro } from './components/ui/faq-pro';

const rootElement = document.getElementById('faq-react-root');

if (rootElement) {
    const rawData = rootElement.getAttribute('data-faqs');
    let items = [];
    
    if (rawData) {
        try {
            const parsedFaqs = JSON.parse(rawData);
            items = parsedFaqs.map((faq: any) => ({
                id: faq.id.toString(),
                question: faq.question,
                answer: faq.answer
            }));
        } catch (error) {
            console.error("Failed to parse FAQs:", error);
        }
    }

    const root = createRoot(rootElement);
    root.render(
        <React.StrictMode>
            <FaqPro items={items} defaultOpenFirst={false} />
        </React.StrictMode>
    );
}
