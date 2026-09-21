"use client"

import React, { useEffect, useRef, useState } from "react"
import { ChevronDown } from "lucide-react"
import { AnimatePresence, motion } from "framer-motion"

export interface DropdownItem {
  id: string | number
  label: string
  icon?: React.ReactNode
  href?: string
}

export interface BasicDropdownProps {
  label: string
  items: DropdownItem[]
  onChange?: (item: DropdownItem) => void
  className?: string
  align?: "left" | "right"
}

export default function BasicDropdown({
  label,
  items,
  onChange,
  className = "",
  align = "right",
}: BasicDropdownProps) {
  const [isOpen, setIsOpen] = useState(false)
  const [selectedItem, setSelectedItem] = useState<DropdownItem | null>(null)
  const dropdownRef = useRef<HTMLDivElement>(null)

  const handleItemSelect = (item: DropdownItem) => {
    setSelectedItem(item)
    setIsOpen(false)
    onChange?.(item)
    if (item.href) {
      window.location.href = item.href
    }
  }

  // Close on outside click
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target as Node)) {
        setIsOpen(false)
      }
    }
    document.addEventListener("mousedown", handleClickOutside)
    return () => document.removeEventListener("mousedown", handleClickOutside)
  }, [])

  const buttonId = "dropdown-button"

  return (
    <div ref={dropdownRef} className={`relative inline-block ${className}`}>
      <button
        id={buttonId}
        onClick={() => setIsOpen(!isOpen)}
        aria-haspopup="menu"
        aria-expanded={isOpen}
        className="flex items-center justify-between gap-1.5 rounded-lg border border-border bg-background px-3 py-1.5 text-xs sm:text-sm font-medium text-foreground shadow-xs transition-colors hover:bg-muted focus:outline-none focus-visible:ring-2 focus-visible:ring-ring cursor-pointer"
      >
        <span className="block truncate">
          {selectedItem ? selectedItem.label : label}
        </span>
        <motion.div
          className="text-muted-foreground"
          animate={{ rotate: isOpen ? 180 : 0 }}
          transition={{ duration: 0.2 }}
        >
          <ChevronDown className="h-4 w-4" />
        </motion.div>
      </button>

      <AnimatePresence>
        {isOpen && (
          <motion.div
            className={`absolute ${align === "right" ? "right-0" : "left-0"} z-50 mt-1.5 w-52 origin-top rounded-lg border border-border bg-background text-foreground shadow-lg overflow-hidden`}
            initial={{ opacity: 0, y: -10, scaleY: 0.95 }}
            animate={{ opacity: 1, y: 0, scaleY: 1 }}
            exit={{ opacity: 0, y: -8, scaleY: 0.95, transition: { duration: 0.15 } }}
            transition={{ type: "spring", bounce: 0.15, duration: 0.3 }}
            role="menu"
            aria-orientation="vertical"
            aria-labelledby={buttonId}
          >
            <ul className="py-1">
              {items.map((item) => {
                const selected = selectedItem?.id === item.id
                return (
                  <motion.li
                    key={item.id}
                    role="none"
                    initial={{ opacity: 0, x: -6 }}
                    animate={{ opacity: 1, x: 0 }}
                    exit={{ opacity: 0, x: -6 }}
                    transition={{ type: "spring", stiffness: 320, damping: 26 }}
                  >
                    <button
                      role="menuitem"
                      onClick={() => handleItemSelect(item)}
                      className={[
                        "flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm transition-colors cursor-pointer",
                        "focus:outline-none focus-visible:ring-1 focus-visible:ring-ring",
                        selected
                          ? "bg-primary/10 text-primary font-medium"
                          : "text-foreground hover:bg-secondary"
                      ].join(" ")}
                    >
                      {item.icon && <span className="shrink-0 text-muted-foreground">{item.icon}</span>}
                      <span className="truncate">{item.label}</span>

                      {selected && (
                        <motion.span
                          className="ml-auto text-primary"
                          initial={{ scale: 0 }}
                          animate={{ scale: 1 }}
                          transition={{ type: "spring", stiffness: 300, damping: 20 }}
                          aria-hidden
                        >
                          <svg
                            className="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              strokeLinecap="round"
                              strokeLinejoin="round"
                              strokeWidth={2}
                              d="M5 13l4 4L19 7"
                            />
                          </svg>
                        </motion.span>
                      )}
                    </button>
                  </motion.li>
                )
              })}
            </ul>
          </motion.div>
        )}
      </AnimatePresence>
    </div>
  )
}
