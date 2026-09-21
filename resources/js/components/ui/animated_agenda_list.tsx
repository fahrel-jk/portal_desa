import React from "react";
import { Clock, MapPin } from "lucide-react";
import { MovingBorder } from "./border";

export interface AgendaEventItem {
  id: number;
  title: string;
  event_date: string;
  month_name: string;
  day_number: string;
  start_time?: string;
  end_time?: string;
  location?: string;
  description?: string;
  category_label?: string;
  category_color?: string;
}

export interface AnimatedAgendaListProps {
  agendas: AgendaEventItem[];
}

export const AnimatedAgendaList: React.FC<AnimatedAgendaListProps> = ({ agendas }) => {
  if (!agendas || agendas.length === 0) {
    return (
      <div className="bg-white/80 backdrop-blur-xl rounded-2xl p-8 flex flex-col items-center justify-center text-center border border-dashed border-slate-300 h-full">
        <div className="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2" /><line x1="16" x2="16" y1="2" y2="6" /><line x1="8" x2="8" y1="2" y2="6" /><line x1="3" x2="21" y1="10" y2="10" /></svg>
        </div>
        <h3 className="font-bold text-lg text-slate-900 mb-1" style={{ fontFamily: "'Outfit', sans-serif" }}>Tidak Ada Agenda Mendatang</h3>
        <p className="text-sm text-slate-500">Belum ada jadwal kegiatan dalam waktu dekat.</p>
      </div>
    );
  }

  return (
    <div className="flex flex-col gap-4">
      {agendas.map((agenda) => {
        const categoryColor = agenda.category_color || "#3b82f6";
        const categorySoft = `color-mix(in srgb, ${categoryColor} 10%, white)`;

        return (
          <div
            key={agenda.id}
            className="group relative p-[1px] overflow-hidden transition-all duration-200"
            style={{
              borderRadius: "16px",
              boxShadow: "0 5px 18px rgba(28, 38, 31, 0.055)",
            }}
          >
            {/* Animated Moving Border Beam */}
            <div className="absolute inset-0 pointer-events-none" style={{ borderRadius: "16px" }}>
              <MovingBorder duration={5000} rx="16px" ry="16px">
                <div
                  className="h-20 w-20 opacity-60"
                  style={{
                    background: `radial-gradient(circle, ${categoryColor} 40%, transparent 60%)`,
                  }}
                />
              </MovingBorder>
            </div>

            {/* Main Card Content */}
            <div
              className="relative w-full h-full overflow-hidden grid transition-all duration-180 group-hover:shadow-[0_9px_24px_rgba(28,38,31,0.08)] group-hover:-translate-y-[1px]"
              style={{
                gridTemplateColumns: "72px minmax(0, 1fr)",
                background: "rgba(255, 255, 255, 0.92)",
                backdropFilter: "blur(20px)",
                WebkitBackdropFilter: "blur(20px)",
                borderRadius: "15px",
                minHeight: "90px",
                border: "1px solid rgba(255, 255, 255, 0.5)",
              }}
            >
              {/* Date Box */}
              <div
                className="relative flex flex-col items-center justify-center p-[16px_8px] min-w-[72px]"
                style={{ background: categorySoft }}
              >
                {/* Left Accent */}
                <div
                  className="absolute inset-y-0 left-0 w-[4px]"
                  style={{ background: categoryColor }}
                />
                <span
                  className="text-[12px] font-bold leading-none uppercase tracking-wider"
                  style={{ color: categoryColor }}
                >
                  {agenda.month_name}
                </span>
                <span
                  className="mt-2 text-[28px] font-bold leading-none text-[#18211b]"
                  style={{ fontFamily: "'Outfit', sans-serif" }}
                >
                  {agenda.day_number}
                </span>
              </div>

              {/* Content */}
              <div className="min-w-0 p-5 sm:px-6 sm:py-5 flex flex-col justify-center">
                <div
                  className="flex items-center gap-2 text-[11px] font-bold uppercase leading-none tracking-wider mb-2"
                  style={{ color: categoryColor }}
                >
                  <span
                    className="w-1.5 h-1.5 rounded-full shrink-0"
                    style={{ background: categoryColor }}
                  />
                  <span className="truncate">{agenda.category_label || "KEGIATAN"}</span>
                </div>

                <h3
                  className="text-[17px] sm:text-[18px] font-bold text-[#202820] leading-snug truncate mb-1.5"
                  style={{ fontFamily: "'Outfit', sans-serif" }}
                >
                  {agenda.title}
                </h3>

                {agenda.description && (
                  <p className="text-[13px] sm:text-[14px] text-[#5c6652] leading-relaxed line-clamp-2 mb-3">
                    {agenda.description}
                  </p>
                )}

                <div className="flex flex-wrap items-center gap-x-5 gap-y-2 text-[13px] text-[#687a92] font-medium mt-auto">
                  {agenda.start_time && (
                    <div className="inline-flex items-center gap-1.5 min-w-0">
                      <Clock className="w-4 h-4 shrink-0" />
                      <span>
                        {agenda.start_time} {agenda.end_time ? `- ${agenda.end_time}` : "WIB"}
                      </span>
                    </div>
                  )}
                  {agenda.location && (
                    <div className="inline-flex items-center gap-1.5 min-w-0">
                      <MapPin className="w-4 h-4 shrink-0" />
                      <span className="truncate">{agenda.location}</span>
                    </div>
                  )}
                </div>
              </div>
            </div>
          </div>
        );
      })}
    </div>
  );
};
