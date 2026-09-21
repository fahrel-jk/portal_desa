import React from "react";
import { createRoot } from "react-dom/client";
import { GlassCalendar } from "./components/ui/glass_calendar";
import { AnimatedAgendaList } from "./components/ui/animated_agenda_list";

function mountGlassCalendars() {
  const mountElements = document.querySelectorAll("#glass-calendar-root, .glass-calendar-mount");

  mountElements.forEach((rootElement) => {
    if (rootElement.getAttribute("data-mounted") === "true") return;
    rootElement.setAttribute("data-mounted", "true");

    const rawEvents = rootElement.getAttribute("data-events");
    const agendaUrl = rootElement.getAttribute("data-agenda-url") || undefined;

    let events: any[] = [];
    if (rawEvents) {
      try {
        events = JSON.parse(rawEvents);
      } catch (error) {
        console.error("Failed to parse calendar events:", error);
      }
    }

    const root = createRoot(rootElement);
    root.render(
      <React.StrictMode>
        <GlassCalendar events={events} agendaPageUrl={agendaUrl} />
      </React.StrictMode>
    );
  });
}

function mountAnimatedAgendaCards() {
  const agendaElements = document.querySelectorAll("#animated-agenda-cards-root, .animated-agenda-cards-mount");

  agendaElements.forEach((rootElement) => {
    if (rootElement.getAttribute("data-mounted") === "true") return;
    rootElement.setAttribute("data-mounted", "true");

    const rawAgendas = rootElement.getAttribute("data-agendas");
    let agendas: any[] = [];
    if (rawAgendas) {
      try {
        agendas = JSON.parse(rawAgendas);
      } catch (error) {
        console.error("Failed to parse agenda cards:", error);
      }
    }

    const root = createRoot(rootElement);
    root.render(
      <React.StrictMode>
        <AnimatedAgendaList agendas={agendas} />
      </React.StrictMode>
    );
  });
}

function initMounts() {
  mountGlassCalendars();
  mountAnimatedAgendaCards();
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initMounts);
} else {
  initMounts();
}
