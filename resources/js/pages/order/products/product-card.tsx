import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { router, usePage } from '@inertiajs/react';
import { store } from '@/routes/order/cart-items';
import { formatMoney } from '@/lib/utils';

type ProductCardProps = {
    product: any;
};

export function ProductCard({ product }: ProductCardProps) {
    const currentCart: any = usePage().props.currentCart;
    const cartItem = currentCart?.cart_items?.find((item: any) => item.product_id === product.id);
    const quantityInCart = cartItem ? cartItem.quantity : 0;

    const handleAddToCart = (product: any) => {
        router.post(store.url(), { product_id: product.id, quantity: 1 }, { preserveScroll: true });
    };

    return (
        <Card key={product.id} className="flex flex-col h-full">
            <CardHeader>
                <CardTitle>{product.name}</CardTitle>
                {product.description && (
                    <CardDescription>{product.description}</CardDescription>
                )}
            </CardHeader>
            <CardContent className="flex flex-col flex-1 justify-between gap-4">
                <div className="text-lg font-semibold">{formatMoney(product.price)}</div>
                <div className="text-sm text-muted-foreground">
                    Stock: {product.stock_quantity}
                </div>
                <Button 
                  type="button"
                  onClick={() => handleAddToCart(product)} 
                  className="mt-2" 
                  disabled={product.stock_quantity <= 0}
                >
                    {product.stock_quantity > 0 ? (
                        <>
                            Add to cart
                            {quantityInCart > 0 && (
                                <span className="ml-2 text-xs font-medium text-accent">({quantityInCart})</span>
                            )}
                        </>
                    ) : (
                        'Out of stock'
                    )}
                </Button>
            </CardContent>
        </Card>
    );
}
