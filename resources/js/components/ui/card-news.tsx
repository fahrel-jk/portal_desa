import * as React from "react";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { ArrowRight, Newspaper, Award, Leaf, Store, HeartHandshake } from "lucide-react";

export interface CardNewsProps extends React.HTMLAttributes<HTMLDivElement> {
  imageUrl?: string;
  imageAlt: string;
  title: string;
  category?: string;
  date: string;
  overview: string;
  url: string;
}

const getCategoryIcon = (category?: string) => {
  const cat = (category || "").toUpperCase();
  if (cat.includes("PRESTASI") || cat.includes("PENGHARGAAN")) {
    return <Award className="h-3.5 w-3.5" />;
  }
  if (cat.includes("LINGKUNGAN") || cat.includes("ALAM")) {
    return <Leaf className="h-3.5 w-3.5" />;
  }
  if (cat.includes("UMKM") || cat.includes("USAHA")) {
    return <Store className="h-3.5 w-3.5" />;
  }
  if (cat.includes("SOSIAL") || cat.includes("BANTUAN")) {
    return <HeartHandshake className="h-3.5 w-3.5" />;
  }
  return <Newspaper className="h-3.5 w-3.5" />;
};

const getFallbackImage = (category?: string, idStr?: string) => {
  const cat = (category || "").toUpperCase();
  if (cat.includes("PRESTASI")) {
    return "https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800&auto=format&fit=crop";
  }
  if (cat.includes("LINGKUNGAN")) {
    return "https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop";
  }
  if (cat.includes("UMKM")) {
    return "https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop";
  }
  if (cat.includes("SOSIAL")) {
    return "https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=800&auto=format&fit=crop";
  }
  return "https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=800&auto=format&fit=crop";
};

const CardNews = React.forwardRef<HTMLDivElement, CardNewsProps>(
  (
    {
      className,
      imageUrl,
      imageAlt,
      title,
      category = "KABAR DESA",
      date,
      overview,
      url,
      ...props
    },
    ref
  ) => {
    const displayImage = imageUrl || getFallbackImage(category, title);

    return (
      <div
        ref={ref}
        className={cn(
          "group relative w-full h-[440px] overflow-hidden rounded-[1.5rem] border border-white/20 bg-slate-900 shadow-md",
          "transition-all duration-300 ease-out hover:shadow-2xl cursor-pointer select-none",
          className
        )}
        onClick={() => (window.location.href = url)}
        {...props}
      >
        {/* Background Image with Zoom Effect */}
        <img
          src={displayImage}
          alt={imageAlt}
          className="absolute inset-0 h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
        />

        {/* Gradient Overlay */}
        <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/15" />

        {/* Content Container — Explicit 28px (1.75rem) padding to guarantee breathing room from edges */}
        <div
          className="relative flex h-full flex-col justify-between text-white z-10"
          style={{ padding: "1.75rem" }}
        >
          {/* Top Section: Frosted Glass Category Chip */}
          <div className="flex justify-start">
            <div
              className="inline-flex items-center justify-center gap-1.5 rounded-full border border-white/30 bg-white/20 text-xs font-semibold uppercase tracking-wider text-white shadow-sm transition-all duration-300 group-hover:bg-white/30"
              style={{
                backgroundColor: "rgba(255, 255, 255, 0.22)",
                backdropFilter: "blur(12px)",
                WebkitBackdropFilter: "blur(12px)",
                borderColor: "rgba(255, 255, 255, 0.35)",
                padding: "0.45rem 0.875rem",
                lineHeight: 1,
              }}
            >
              {getCategoryIcon(category)}
              <span style={{ transform: "translateY(0.5px)" }}>{category}</span>
            </div>
          </div>

          {/* Bottom Section: Title, Overview, and Hover-Reveal Date + Detail Button */}
          <div className="space-y-3">
            <div>
              <h3
                className="text-lg sm:text-xl font-bold leading-snug line-clamp-2 transition-colors duration-200"
                style={{ color: "#ffffff", fontFamily: "'Outfit', sans-serif" }}
              >
                {title}
              </h3>
            </div>

            <p className="text-xs sm:text-sm text-gray-200/90 leading-relaxed line-clamp-2">
              {overview}
            </p>

            {/* Hover-Reveal Action Bar */}
            <div className="pt-3 border-t border-white/20 opacity-0 translate-y-3 transition-all duration-300 ease-out group-hover:opacity-100 group-hover:translate-y-0">
              <div className="flex items-center justify-between">
                <div>
                  <span className="text-xs sm:text-sm font-bold text-white tracking-wide">
                    {date}
                  </span>
                </div>

                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    window.location.href = url;
                  }}
                  className="inline-flex items-center justify-center gap-1.5 text-white font-semibold text-xs rounded-full shadow-md transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer"
                  style={{
                    backgroundColor: "var(--primary, #c4654a)",
                    padding: "0.5rem 1.125rem",
                    lineHeight: 1,
                    border: "none",
                  }}
                >
                  <span style={{ transform: "translateY(0.5px)" }}>Detail</span>
                  <ArrowRight className="h-3.5 w-3.5 shrink-0" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
);
CardNews.displayName = "CardNews";

export { CardNews };





