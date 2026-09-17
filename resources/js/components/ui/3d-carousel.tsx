"use client"

import { memo, useEffect, useLayoutEffect, useState } from "react"
import {
  AnimatePresence,
  motion,
  useAnimation,
  useMotionValue,
  useTransform,
} from "framer-motion"
import { cn } from "@/lib/utils"

export const useIsomorphicLayoutEffect =
  typeof window !== "undefined" ? useLayoutEffect : useEffect

type UseMediaQueryOptions = {
  defaultValue?: boolean
  initializeWithValue?: boolean
}

const IS_SERVER = typeof window === "undefined"

export function useMediaQuery(
  query: string,
  {
    defaultValue = false,
    initializeWithValue = true,
  }: UseMediaQueryOptions = {}
): boolean {
  const getMatches = (query: string): boolean => {
    if (IS_SERVER) {
      return defaultValue
    }
    return window.matchMedia(query).matches
  }

  const [matches, setMatches] = useState<boolean>(() => {
    if (initializeWithValue) {
      return getMatches(query)
    }
    return defaultValue
  })

  const handleChange = () => {
    setMatches(getMatches(query))
  }

  useIsomorphicLayoutEffect(() => {
    const matchMedia = window.matchMedia(query)
    handleChange()

    matchMedia.addEventListener("change", handleChange)

    return () => {
      matchMedia.removeEventListener("change", handleChange)
    }
  }, [query])

  return matches
}

export type CardData = {
    image_path: string;
    caption?: string;
};

const duration = 0.15
const transition = { duration, ease: [0.32, 0.72, 0, 1], filter: "blur(4px)" }
const transitionOverlay = { duration: 0.5, ease: [0.32, 0.72, 0, 1] }

const Carousel = memo(
  ({
    handleClick,
    controls,
    cards,
    isCarouselActive,
  }: {
    handleClick: (card: CardData, index: number) => void
    controls: any
    cards: CardData[]
    isCarouselActive: boolean
  }) => {
    const isScreenSizeSm = useMediaQuery("(max-width: 640px)")
    
    const faceCount = Math.max(cards.length, 1)
    
    // We want cards to be wider and have gaps between them.
    // baseFaceWidth is the slice width (card width + gap)
    const baseFaceWidth = isScreenSizeSm ? 260 : 400
    const minCylinderWidth = isScreenSizeSm ? 1100 : 1800
    
    // Circumference grows with items, ensuring they don't get squished
    const cylinderWidth = Math.max(faceCount * baseFaceWidth, minCylinderWidth)
    const faceWidth = cylinderWidth / faceCount
    const radius = cylinderWidth / (2 * Math.PI)
    
    const rotation = useMotionValue(0)
    
    // Custom transform string ensures that the physical `x` from drag is ignored,
    // and correctly applies Z translation BEFORE Y rotation for proper orbiting.
    const transform = useTransform(
      rotation,
      (value) => `translateZ(-${radius}px) rotateY(${value}deg)`
    )

    return (
      <div
        className="flex h-full items-center justify-center bg-transparent"
        style={{
          perspective: "1200px",
          transformStyle: "preserve-3d",
          willChange: "transform",
        }}
      >
        <motion.div
          drag={isCarouselActive ? "x" : false}
          className="relative flex h-full origin-center cursor-grab justify-center active:cursor-grabbing"
          style={{
            transform, // Using custom transform prevents physical X shifting!
            width: "100%", // Prevent wide plane clipping
            transformStyle: "preserve-3d",
          }}
          onDrag={(_, info) =>
            isCarouselActive &&
            rotation.set(rotation.get() + info.delta.x * 0.25) // Fixed: Use delta instead of offset!
          }
          onDragEnd={(_, info) =>
            isCarouselActive &&
            controls.start({
              rotateY: rotation.get() + info.velocity.x * 0.05,
              transition: {
                type: "spring",
                stiffness: 100,
                damping: 30,
                mass: 0.1,
              },
            })
          }
          animate={controls}
        >
          {cards.map((card, i) => (
            <motion.div
              key={`key-${card.image_path}-${i}`}
              className="absolute flex h-full origin-center items-center justify-center"
              style={{
                width: `${faceWidth}px`,
                transform: `rotateY(${
                  i * (360 / faceCount)
                }deg) translateZ(${radius}px)`,
              }}
              onClick={() => handleClick(card, i)}
            >
              {/* Max width and w-[90%] creates the gap! */}
              <motion.div 
                className="w-[90%] max-w-[240px] sm:max-w-[360px] h-auto aspect-[4/3] sm:aspect-square rounded-2xl overflow-hidden shadow-2xl bg-muted cursor-pointer transition-transform duration-300 hover:scale-[1.02]"
                style={{ boxShadow: "0 20px 40px -10px rgba(0,0,0,0.5)" }}
              >
                  <motion.img
                    src={card.image_path}
                    alt={card.caption || "Galeri"}
                    layoutId={`img-${card.image_path}`}
                    className="pointer-events-none w-full h-full rounded-2xl object-cover"
                    initial={{ filter: "blur(4px)" }}
                    layout="position"
                    animate={{ filter: "blur(0px)" }}
                    transition={transition}
                  />
              </motion.div>
            </motion.div>
          ))}
        </motion.div>
      </div>
    )
  }
)

export function ThreeDPhotoCarousel({ cardsData }: { cardsData: CardData[] }) {
  const [activeImg, setActiveImg] = useState<CardData | null>(null)
  const [isCarouselActive, setIsCarouselActive] = useState(true)
  const controls = useAnimation()
  const cards = cardsData.length > 0 ? cardsData : [];

  const handleClick = (card: CardData) => {
    setActiveImg(card)
    setIsCarouselActive(false)
    controls.stop()
  }

  const handleClose = () => {
    setActiveImg(null)
    setIsCarouselActive(true)
  }

  return (
    <motion.div layout className="relative">
      <AnimatePresence mode="sync">
        {activeImg && (
          <motion.div
            initial={{ opacity: 0, scale: 0 }}
            animate={{ opacity: 1, scale: 1 }}
            exit={{ opacity: 0, scale: 0 }}
            layoutId={`img-container-${activeImg.image_path}`}
            layout="position"
            onClick={handleClose}
            className="fixed inset-0 bg-black/30 backdrop-blur-md flex items-center justify-center z-[100] p-4 sm:p-8"
            style={{ willChange: "opacity" }}
            transition={transitionOverlay}
          >
            <div className="relative max-w-5xl w-full max-h-full flex flex-col items-center justify-center" onClick={(e) => e.stopPropagation()}>
                <button onClick={handleClose} className="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 z-50">
                    <svg className="w-8 h-8" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <motion.img
                layoutId={`img-${activeImg.image_path}`}
                src={activeImg.image_path}
                className="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain"
                initial={{ scale: 0.5 }}
                animate={{ scale: 1 }}
                transition={{
                    delay: 0.2,
                    duration: 0.5,
                    ease: [0.25, 0.1, 0.25, 1],
                }}
                style={{
                    willChange: "transform",
                }}
                />
                {activeImg.caption && (
                    <motion.div 
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.5 }}
                        className="mt-4 px-6 py-2 rounded-full bg-white/10 text-white text-sm backdrop-blur-md"
                    >
                        {activeImg.caption}
                    </motion.div>
                )}
            </div>
          </motion.div>
        )}
      </AnimatePresence>
      <div 
        className="relative h-[450px] sm:h-[550px] w-full overflow-hidden rounded-3xl"
        style={{
            maskImage: "linear-gradient(to right, transparent, black 15%, black 85%, transparent)",
            WebkitMaskImage: "linear-gradient(to right, transparent, black 15%, black 85%, transparent)"
        }}
      >
        <Carousel
          handleClick={handleClick}
          controls={controls}
          cards={cards}
          isCarouselActive={isCarouselActive}
        />
      </div>
    </motion.div>
  )
}
