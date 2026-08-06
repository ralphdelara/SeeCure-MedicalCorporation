import * as React from "react"

import { cn } from "@/lib/utils"
import { Options } from "@/types/options";

interface SelectProps extends React.ComponentProps<"select"> {
    options: Options[];
    className?: string;
    type?: string;
}

function Select({ className, options = [], type, ...props }: SelectProps) {
  return (
    <select
      data-slot="select"
      className={cn(
        "form-select",
        className
      )}
      {...props}
    >
        <option value="">Select { type }</option>
        {options.map((item, index) => (
            <option key={index} value={ item.id }>{ item.name }</option>
        ))}
    </select>
  )
}

export { Select }
