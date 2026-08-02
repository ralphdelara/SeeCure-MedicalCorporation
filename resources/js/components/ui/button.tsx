import { Slot } from "@radix-ui/react-slot"
import { cva, type VariantProps } from "class-variance-authority"
import * as React from "react"

import { cn } from "@/lib/utils"

const buttonVariants = cva(
    "",
    {
        variants: {
            variant: {
                default:
                    "btn btn-success shadow-sm",
                danger:
                    "btn btn-danger shadow-sm",
                light:
                    "btn btn-light shadow-sm",
            },
            size: {
                default: "btn-md",
                sm: "btn-sm",
                lg: "btn-lg",
            },
            rounded: {
                true: "rounded-circle round-32",
                false: "",
            },
            hasIcon: {
                true: "btn-icon-text",
                false: "",
            },
        },
        defaultVariants: {
            variant: "default",
            size: "default",
            rounded: false,
        },
    }
)

function Button({
    className,
    variant,
    size,
    hasIcon = false,
    rounded,
    title,
    asChild = false,
    children,
    ...props
}: React.ComponentProps<"button"> &
    VariantProps<typeof buttonVariants> & {
        title?: string;
        asChild?: boolean;
    }) {
    const Comp = asChild ? Slot : "button"

    return (
        <Comp
            data-slot="button"
            className={
                cn(buttonVariants({ variant, size, rounded, hasIcon, className }))
                + (title ? ' tooltip-container' : '')
            }
            {...props}
            data-title={ title }
        >
            {children}
        </Comp>
    )
}

export { Button, buttonVariants }
