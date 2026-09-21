"use client";

import { ChevronDown, X, Search } from "lucide-react";
import * as React from "react";

export type FaqProItem = {
  id: string;
  question: string;
  answer: string;
  category?: string;
};

export type FaqProProps = {
  className?: string;
  defaultOpenFirst?: boolean;
  items: FaqProItem[];
  searchPlaceholder?: string;
};

function escapeRegExp(value: string) {
  return value.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function highlightText(text: string, query: string) {
  const normalizedQuery = query.trim();
  if (!normalizedQuery) return text;

  const parts = text.split(
    new RegExp(`(${escapeRegExp(normalizedQuery)})`, "gi")
  );

  return parts.map((part, index) => {
    if (part.toLowerCase() === normalizedQuery.toLowerCase()) {
      return (
        <mark
          style={{
            backgroundColor: "rgba(253, 230, 138, 0.9)",
            color: "#1e293b",
            padding: "0 2px",
            borderRadius: "2px",
          }}
          key={index}
        >
          {part}
        </mark>
      );
    }
    return <React.Fragment key={index}>{part}</React.Fragment>;
  });
}

function itemMatchesQuery(item: FaqProItem, query: string) {
  const normalizedQuery = query.trim().toLowerCase();
  if (!normalizedQuery) return true;

  return (
    item.question.toLowerCase().includes(normalizedQuery) ||
    item.answer.toLowerCase().includes(normalizedQuery) ||
    (item.category && item.category.toLowerCase().includes(normalizedQuery))
  );
}

type FaqProRowProps = {
  isOpen: boolean;
  item: FaqProItem;
  onToggle: () => void;
  panelId: string;
  query: string;
  triggerId: string;
  index: number;
};

function FaqProRow({
  isOpen,
  item,
  onToggle,
  panelId,
  query,
  triggerId,
  index,
}: FaqProRowProps) {
  const rowRef = React.useRef<HTMLDivElement>(null);

  // Stagger reveal via IntersectionObserver
  React.useEffect(() => {
    const el = rowRef.current;
    if (!el) return;
    el.style.setProperty("--reveal-delay", `${index * 75}ms`);
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            e.target.classList.add("is-visible");
            io.unobserve(e.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    io.observe(el);
    return () => io.disconnect();
  }, [index]);

  return (
    <div ref={rowRef} className="faq-reveal faq-card">
      <button
        aria-controls={panelId}
        aria-expanded={isOpen}
        id={triggerId}
        onClick={onToggle}
        type="button"
        className={`faq-trigger ${isOpen ? "faq-trigger--open" : ""}`}
      >
        <span className="faq-trigger-content">
          {item.category && (
            <span className="faq-badge">{item.category}</span>
          )}
          <span className="faq-question">
            {highlightText(item.question, query)}
          </span>
        </span>
        <svg
          data-open={isOpen}
          className="faq-chevron"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth={2}
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            d="M19 9l-7 7-7-7"
          />
        </svg>
      </button>

      <div
        id={panelId}
        role="region"
        aria-labelledby={triggerId}
        data-open={isOpen}
        className="faq-panel"
      >
        <div>
          <p className="faq-answer">{highlightText(item.answer, query)}</p>
        </div>
      </div>
    </div>
  );
}

function FaqPro({
  defaultOpenFirst = true,
  items,
  searchPlaceholder = "Cari pertanyaan…",
}: FaqProProps) {
  const listId = React.useId();
  const [query, setQuery] = React.useState("");
  const [openId, setOpenId] = React.useState<string | null>(() =>
    defaultOpenFirst && items[0] ? items[0].id : null
  );

  const visibleItems = React.useMemo(
    () => items.filter((item) => itemMatchesQuery(item, query)),
    [items, query]
  );

  React.useEffect(() => {
    if (query.trim()) {
      setOpenId((current) => {
        if (current && visibleItems.some((item) => item.id === current)) {
          return current;
        }
        return visibleItems[0]?.id ?? null;
      });
    }
  }, [query, visibleItems]);

  const toggleItem = React.useCallback((id: string) => {
    setOpenId((current) => (current === id ? null : id));
  }, []);

  return (
    <div className="faq-container">
      {/* Search Input */}
      <div className="faq-search-wrapper">
        <Search className="faq-search-icon" />
        <input
          aria-label={searchPlaceholder}
          onChange={(event) => setQuery(event.target.value)}
          placeholder={searchPlaceholder}
          type="search"
          value={query}
          className="faq-search-input"
        />
        {query ? (
          <button
            aria-label="Clear search"
            onClick={() => setQuery("")}
            type="button"
            className="faq-search-clear"
          >
            <X style={{ width: "16px", height: "16px" }} />
          </button>
        ) : null}
      </div>

      {/* Accordion Items - Each item is its own card */}
      <div className="faq-list">
        {visibleItems.length > 0 ? (
          visibleItems.map((item, index) => (
            <FaqProRow
              key={item.id}
              isOpen={openId === item.id}
              item={item}
              onToggle={() => toggleItem(item.id)}
              panelId={`${listId}-${item.id}-panel`}
              query={query}
              triggerId={`${listId}-${item.id}-trigger`}
              index={index}
            />
          ))
        ) : (
          <div className="faq-empty">
            <p className="faq-empty-text">
              Tidak ada pertanyaan yang sesuai dengan pencarian.
            </p>
            <button
              onClick={() => setQuery("")}
              className="faq-empty-reset"
            >
              Reset pencarian
            </button>
          </div>
        )}
      </div>
    </div>
  );
}

FaqPro.displayName = "FaqPro";

export { FaqPro };
