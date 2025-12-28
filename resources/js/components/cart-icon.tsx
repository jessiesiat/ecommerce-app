import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { usePage } from "@inertiajs/react";
import { ShoppingCart } from "lucide-react";

export default function CartIcon() {
    const currentCart: any = usePage().props.currentCart;
    const cartItemsCount = currentCart?.cart_items?.length ?? 0;
    
    return (
        <div className="relative">
            <Badge
                className="absolute top-[-3px] right-[-3px] h-5 min-w-5 rounded-full px-1 font-mono tabular-nums"
                variant={cartItemsCount > 0 ? "destructive" : "outline"}
                >
                {cartItemsCount}
            </Badge>
            <Button
                variant="ghost"
                className="group cursor-pointer"
            >
                <span className="sr-only">Cart</span>
                <ShoppingCart className="!size-5 opacity-80 group-hover:opacity-100" />
            </Button>
        </div>
    );
}
