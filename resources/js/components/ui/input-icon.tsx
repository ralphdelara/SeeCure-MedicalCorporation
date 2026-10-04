import * as React from "react"

import { cn } from "@/lib/utils"

interface InputIconProps extends React.ComponentProps<"input"> {
    icon: React.ReactNode;
    title: string;
}

function InputIcon({ className,  type = "text", title, icon, ...props }: InputIconProps) {
    return (
        <div className="form-group">
            <div className="form-floating mb-3">
                <input
                    type={type}
                    data-slot="input"
                    className={cn(
                        "form-control border-success border",
                        className
                    )}
                    placeholder={title}
                    {...props}
                />
                <label>
                    <span className="fs-4 text-success me-2">{icon}</span>
                    <span className="border-start border-success ps-3">
                        {title}
                    </span>
                </label>
            </div>
        </div>
    )
}

export { InputIcon }
