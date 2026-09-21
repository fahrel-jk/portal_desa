import * as React from "react";
import { ChevronLeft, ChevronRight, Clock, MapPin } from "lucide-react";
import {
  format,
  addMonths,
  subMonths,
  isSameDay,
  isToday,
  getDate,
  getDaysInMonth,
  startOfMonth,
  getDay,
} from "date-fns";
import { id as idLocale } from "date-fns/locale";
import { motion, AnimatePresence } from "framer-motion";

// --- TYPE DEFINITIONS ---
export interface AgendaEvent {
  id: number;
  title: string;
  event_date: string;
  start_time?: string;
  end_time?: string;
  location?: string;
  category_label?: string;
  category_color?: string;
}

export interface Day {
  date: Date;
  isToday: boolean;
  isSelected: boolean;
  events: AgendaEvent[];
}

export interface GlassCalendarProps extends React.HTMLAttributes<HTMLDivElement> {
  selectedDate?: Date;
  onDateSelect?: (date: Date) => void;
  events?: AgendaEvent[];
  agendaPageUrl?: string;
  className?: string;
}

// --- HELPER TO HIDE SCROLLBAR ---
const ScrollbarHide = () => (
  <style>{`
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  `}</style>
);

const DAY_NAMES = ["SEN", "SEL", "RAB", "KAM", "JUM", "SAB", "MIN"];

export const GlassCalendar = React.forwardRef<
  HTMLDivElement,
  GlassCalendarProps
>(
  (
    {
      className = "",
      selectedDate: propSelectedDate,
      onDateSelect,
      events = [],
      agendaPageUrl,
      ...props
    },
    ref
  ) => {
    const [currentMonth, setCurrentMonth] = React.useState(
      propSelectedDate || new Date()
    );
    const [selectedDate, setSelectedDate] = React.useState(
      propSelectedDate || new Date()
    );
    const [direction, setDirection] = React.useState(0);

    // Build events map for quick lookup
    const eventsMap = React.useMemo(() => {
      const map: Record<string, AgendaEvent[]> = {};
      events.forEach((evt) => {
        const key = evt.event_date; // expected "YYYY-MM-DD"
        if (!map[key]) map[key] = [];
        map[key].push(evt);
      });
      return map;
    }, [events]);

    // Generate calendar grid
    const calendarGrid = React.useMemo(() => {
      const monthStart = startOfMonth(currentMonth);
      const totalDays = getDaysInMonth(currentMonth);
      let startDow = getDay(monthStart) - 1;
      if (startDow < 0) startDow = 6; // Sunday -> 6

      const days: (Day | null)[] = [];

      for (let i = 0; i < startDow; i++) {
        days.push(null);
      }

      for (let d = 1; d <= totalDays; d++) {
        const date = new Date(
          monthStart.getFullYear(),
          monthStart.getMonth(),
          d
        );
        const dateStr = format(date, "yyyy-MM-dd");
        days.push({
          date,
          isToday: isToday(date),
          isSelected: isSameDay(date, selectedDate),
          events: eventsMap[dateStr] || [],
        });
      }

      return days;
    }, [currentMonth, selectedDate, eventsMap]);

    // Selected date events
    const selectedDateEvents = React.useMemo(() => {
      const key = format(selectedDate, "yyyy-MM-dd");
      return eventsMap[key] || [];
    }, [selectedDate, eventsMap]);

    const handleDateClick = (date: Date) => {
      setSelectedDate(date);
      onDateSelect?.(date);
    };

    const handlePrevMonth = () => {
      setDirection(-1);
      setCurrentMonth(subMonths(currentMonth, 1));
    };

    const handleNextMonth = () => {
      setDirection(1);
      setCurrentMonth(addMonths(currentMonth, 1));
    };

    return (
      <div
        ref={ref}
        className={`w-full mx-auto relative ${className}`}
        style={{
          width: "100%",
          padding: "26px 26px 22px",
          borderRadius: "1.5rem",
          background: "var(--card)",
          border: "1px solid var(--border)",
          overflow: "hidden",
          boxSizing: "border-box",
          fontFamily: "'Figtree', system-ui, sans-serif",
        }}
        {...props}
      >
        <ScrollbarHide />

        {/* Header: Month/Year & Navigation */}
        <div
          style={{
            position: "relative",
            zIndex: 10,
            display: "flex",
            alignItems: "center",
            justifyContent: "space-between",
            marginBottom: "18px",
            width: "100%",
          }}
        >
          <AnimatePresence mode="wait" initial={false}>
            <motion.h3
              key={format(currentMonth, "yyyy-MM")}
              initial={{ opacity: 0, y: direction * 8 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0, y: direction * -8 }}
              transition={{ duration: 0.18 }}
              style={{
                fontFamily: "'Outfit', sans-serif",
                fontSize: "21px",
                fontWeight: 800,
                color: "#2a2f23",
                textTransform: "capitalize",
                letterSpacing: "-0.02em",
                margin: 0,
                lineHeight: 1.25,
                paddingLeft: "2px",
              }}
            >
              {format(currentMonth, "MMMM yyyy", { locale: idLocale })}
            </motion.h3>
          </AnimatePresence>

          <div style={{ display: "flex", alignItems: "center", gap: "8px" }}>
            <button
              onClick={handlePrevMonth}
              title="Bulan sebelumnya"
              aria-label="Bulan sebelumnya"
              style={{
                width: "36px",
                height: "36px",
                borderRadius: "11px",
                background: "rgba(255, 255, 255, 0.85)",
                border: "1px solid rgba(255, 255, 255, 0.95)",
                boxShadow: "0 2px 8px rgba(42, 47, 35, 0.06)",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                color: "#2a2f23",
                cursor: "pointer",
                transition: "all 0.2s",
              }}
            >
              <ChevronLeft className="h-4 w-4" />
            </button>
            <button
              onClick={handleNextMonth}
              title="Bulan berikutnya"
              aria-label="Bulan berikutnya"
              style={{
                width: "36px",
                height: "36px",
                borderRadius: "11px",
                background: "rgba(255, 255, 255, 0.85)",
                border: "1px solid rgba(255, 255, 255, 0.95)",
                boxShadow: "0 2px 8px rgba(42, 47, 35, 0.06)",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                color: "#2a2f23",
                cursor: "pointer",
                transition: "all 0.2s",
              }}
            >
              <ChevronRight className="h-4 w-4" />
            </button>
          </div>
        </div>

        {/* Day-of-week headers */}
        <div
          style={{
            position: "relative",
            zIndex: 10,
            display: "grid",
            gridTemplateColumns: "repeat(7, 1fr)",
            gap: "6px",
            textAlign: "center",
            marginBottom: "10px",
          }}
        >
          {DAY_NAMES.map((name) => (
            <span
              key={name}
              style={{
                fontSize: "12px",
                fontWeight: 800,
                color: "#5c6652",
                textTransform: "uppercase",
                letterSpacing: "0.08em",
                padding: "4px 0",
              }}
            >
              {name}
            </span>
          ))}
        </div>

        {/* Calendar Grid */}
        <AnimatePresence mode="wait" initial={false}>
          <motion.div
            key={format(currentMonth, "yyyy-MM")}
            initial={{ opacity: 0, x: direction * 20 }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: direction * -20 }}
            transition={{ duration: 0.18 }}
            style={{
              position: "relative",
              zIndex: 10,
              display: "grid",
              gridTemplateColumns: "repeat(7, 1fr)",
              gap: "7px",
            }}
          >
            {calendarGrid.map((day, idx) =>
              day === null ? (
                <div key={`empty-${idx}`} style={{ aspectRatio: "1/1" }} />
              ) : (
                <button
                  key={format(day.date, "yyyy-MM-dd")}
                  onClick={() => handleDateClick(day.date)}
                  aria-pressed={day.isSelected}
                  aria-label={`${getDate(day.date)} ${format(day.date, "MMMM", { locale: idLocale })}${
                    day.events.length > 0 ? `, ${day.events[0].title}` : ""
                  }`}
                  style={{
                    aspectRatio: "1/1",
                    borderRadius: "14px",
                    fontSize: "15px",
                    fontWeight: day.isSelected || day.isToday ? 800 : 600,
                    display: "flex",
                    flexDirection: "column",
                    alignItems: "center",
                    justifyContent: "center",
                    position: "relative",
                    cursor: "pointer",
                    transition: "all 0.2s",
                    fontFamily: "'Figtree', sans-serif",
                    ...(day.isSelected
                      ? {
                          background: "#c4654a",
                          color: "#ffffff",
                          boxShadow: "0 8px 22px rgba(196, 101, 74, 0.35)",
                          transform: "scale(1.05)",
                          border: "1px solid rgba(255, 255, 255, 0.8)",
                        }
                      : day.isToday
                      ? {
                          background: "rgba(232, 168, 124, 0.3)",
                          border: "1.5px solid #c4654a",
                          color: "#c4654a",
                          boxShadow: "0 2px 6px rgba(42, 47, 35, 0.04)",
                        }
                      : {
                          background: "rgba(255, 255, 255, 0.5)",
                          border: "1px solid transparent",
                          color: "#2a2f23",
                        }),
                  }}
                >
                  <span style={{ lineHeight: 1, marginTop: day.events.length > 0 ? "-3px" : "0" }}>
                    {getDate(day.date)}
                  </span>

                  {/* Event dots below numbers */}
                  {day.events.length > 0 && (
                    <div
                      style={{
                        position: "absolute",
                        bottom: "5px",
                        display: "flex",
                        gap: "3.5px",
                        justifyContent: "center",
                      }}
                    >
                      {day.events.slice(0, 3).map((evt, i) => (
                        <span
                          key={i}
                          style={{
                            width: "5.5px",
                            height: "5.5px",
                            borderRadius: "50%",
                            backgroundColor: day.isSelected ? "#ffffff" : (evt.category_color || "#c4654a"),
                            boxShadow: day.isSelected ? "0 1px 2px rgba(0,0,0,0.2)" : "0 1px 2px rgba(0,0,0,0.12)",
                          }}
                        />
                      ))}
                    </div>
                  )}
                </button>
              )
            )}
          </motion.div>
        </AnimatePresence>

        {/* Bottom Translucent Liquid Glass Event Panel */}
        <div
          style={{
            position: "relative",
            zIndex: 10,
            marginTop: "18px",
            borderRadius: "18px",
            background: "color-mix(in srgb, var(--bg) 50%, white)",
            border: "1px solid var(--border)",
            padding: "14px 16px",
            boxSizing: "border-box",
          }}
        >
          <div
            style={{
              display: "flex",
              alignItems: "center",
              justifyContent: "space-between",
              marginBottom: "10px",
              paddingBottom: "8px",
              borderBottom: "1px solid rgba(42, 47, 35, 0.08)",
            }}
          >
            <span
              style={{
                fontSize: "12px",
                fontWeight: 800,
                color: "#2a2f23",
                textTransform: "uppercase",
                letterSpacing: "0.08em",
                display: "flex",
                alignItems: "center",
                gap: "7px",
              }}
            >
              <span
                style={{
                  width: "8px",
                  height: "8px",
                  borderRadius: "50%",
                  backgroundColor: "#c4654a",
                  boxShadow: "0 0 6px rgba(196, 101, 74, 0.5)",
                }}
              />
              {format(selectedDate, "EEEE, d MMMM yyyy", { locale: idLocale })}
            </span>
            {agendaPageUrl && (
              <a
                href={agendaPageUrl}
                style={{
                  fontSize: "12px",
                  fontWeight: 800,
                  color: "#c4654a",
                  textDecoration: "none",
                  display: "flex",
                  alignItems: "center",
                  gap: "2px",
                }}
              >
                Semua Agenda →
              </a>
            )}
          </div>

          {selectedDateEvents.length > 0 ? (
            <div
              className="scrollbar-hide"
              style={{
                display: "flex",
                flexDirection: "column",
                gap: "8px",
                maxHeight: "160px",
                overflowY: "auto",
              }}
            >
              {selectedDateEvents.map((evt) => (
                <div
                  key={evt.id}
                  style={{
                    padding: "10px 12px",
                    borderRadius: "12px",
                    background: "var(--card)",
                    border: "1px solid var(--border)",
                  }}
                >
                  <div
                    style={{
                      display: "flex",
                      alignItems: "center",
                      gap: "8px",
                    }}
                  >
                    <span
                      style={{
                        width: "8px",
                        height: "8px",
                        borderRadius: "50%",
                        flexShrink: 0,
                        backgroundColor: evt.category_color || "#c4654a",
                      }}
                    />
                    <p
                      style={{
                        fontSize: "14px",
                        fontWeight: 700,
                        color: "#2a2f23",
                        lineHeight: 1.35,
                        margin: 0,
                        fontFamily: "'Outfit', sans-serif",
                        whiteSpace: "nowrap",
                        overflow: "hidden",
                        textOverflow: "ellipsis",
                      }}
                    >
                      {evt.title}
                    </p>
                  </div>
                  <div
                    style={{
                      display: "flex",
                      flexWrap: "wrap",
                      alignItems: "center",
                      gap: "10px",
                      marginTop: "5px",
                      marginLeft: "16px",
                      fontSize: "12px",
                      fontWeight: 600,
                      color: "#5c6652",
                    }}
                  >
                    {evt.start_time && (
                      <span
                        style={{
                          display: "flex",
                          alignItems: "center",
                          gap: "4px",
                        }}
                      >
                        <Clock className="w-3.5 h-3.5 text-slate-500" />
                        {evt.start_time.slice(0, 5)}
                        {evt.end_time
                          ? ` - ${evt.end_time.slice(0, 5)}`
                          : " WIB"}
                      </span>
                    )}
                    {evt.location && (
                      <span
                        style={{
                          display: "flex",
                          alignItems: "center",
                          gap: "4px",
                          overflow: "hidden",
                          textOverflow: "ellipsis",
                          whiteSpace: "nowrap",
                        }}
                      >
                        <MapPin className="w-3.5 h-3.5 text-slate-500 shrink-0" />
                        <span>{evt.location}</span>
                      </span>
                    )}
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <div style={{ padding: "8px 0", textAlign: "center" }}>
              <p
                style={{
                  fontSize: "13px",
                  fontWeight: 600,
                  color: "#5c6652",
                  margin: 0,
                }}
              >
                Tidak ada agenda pada tanggal ini.
              </p>
            </div>
          )}
        </div>
      </div>
    );
  }
);

GlassCalendar.displayName = "GlassCalendar";


