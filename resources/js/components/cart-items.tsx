import { usePage, router } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import {
  Sheet,
  SheetContent,
  SheetFooter,
  SheetHeader,
  SheetTitle,
  SheetTrigger,
} from "@/components/ui/sheet";
import { destroy, update } from "@/routes/order/cart-items";
import CartIcon from "./cart-icon";
import { Link } from "@inertiajs/react";
import { checkout } from "@/routes/order/cart";
import { formatMoney } from "@/lib/utils";

export function CartItems() {
  const currentCart: any = usePage().props.currentCart;
  const cartItems = currentCart?.cart_items ?? [];

  const updateItemQuantity = (cartItem: any, newQuantity: number) => {
    if (newQuantity < 1) {
      // Remove item if quantity less than 1
      router.delete(destroy.url(cartItem.id), { preserveScroll: true });
    } else {
      router.put(update.url(cartItem.id), { quantity: newQuantity }, { preserveScroll: true });
    }
  };

  return (
    <Sheet>
      <SheetTrigger>
        <CartIcon />
      </SheetTrigger>
      <SheetContent className="w-full max-w-md">
        <SheetHeader>
          <SheetTitle>Your Cart</SheetTitle>
        </SheetHeader>
        <div className="flex flex-1 flex-col gap-4 overflow-y-auto max-h-[60vh] py-4 px-4">
          {cartItems.length === 0 ? (
            <div className="text-center text-muted-foreground py-10">Your cart is empty.</div>
          ) : (
            cartItems.map((item: any) => (
              <div
                key={item.id}
                className="flex items-center justify-between border-b last:border-b-0 pb-2 mb-2 last:mb-0"
              >
                <div>
                  <div className="font-medium">{item.name}</div>
                  <div className="text-sm text-muted-foreground">
                    {item.quantity} &times; {formatMoney(item.unit_price)}
                  </div>
                </div>
                <div className="flex items-center gap-2">
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={() => updateItemQuantity(item, item.quantity - 1)}
                  >
                    -
                  </Button>
                  <span className="px-2">{item.quantity}</span>
                  <Button
                    variant="outline"
                    size="sm"
                    onClick={() => updateItemQuantity(item, item.quantity + 1)}
                  >
                    +
                  </Button>
                </div>
              </div>
            ))
          )}
        </div>
        {cartItems.length > 0 && (
          <div className="flex flex-col gap-3 border-t pt-4 px-4">
            <div className="flex justify-between text-base font-semibold">
              <span>Total</span>
              <span>{formatMoney(currentCart.total_amount)}</span>
            </div>
          </div>
        )}
        <SheetFooter className="mt-6">
          {cartItems.length > 0 && (
            <Button type="button" size="xl" asChild>
              <Link href={checkout.url()} method="post">
                Checkout
              </Link>
            </Button>
          )}
          {/* <SheetClose asChild>
            <Button variant="outline" type="button">
              Close
            </Button>
          </SheetClose> */}
        </SheetFooter>
      </SheetContent>
    </Sheet>
  );
}
