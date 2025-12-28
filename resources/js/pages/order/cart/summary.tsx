import OrderLayout from '@/layouts/order-layout';
import { Head, Link } from '@inertiajs/react';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { dashboard } from '@/routes';
import { formatMoney } from '@/lib/utils';

export default function CartSummary({ cart }: any) {
    return (
        <OrderLayout>
            <Head title="Checkout Summary" />
            <div className="max-w-7xl mx-auto pt-12">
                <Card>
                    <CardHeader>
                        <CardTitle>Thank you for your order!</CardTitle>
                        <CardDescription>
                            Your cart has been checked out successfully.
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="mb-4">
                            <div className="text-lg font-bold mb-2">Order Summary</div>
                            <ul className="mb-4">
                                {cart.cart_items && cart.cart_items.length > 0 ? (
                                    cart.cart_items.map((item: any) => (
                                        <li key={item.id} className="flex justify-between py-1 border-b last:border-b-0">
                                            <span>{item.name} x {item.quantity}</span>
                                            <span>{formatMoney(item.line_total)}</span>
                                        </li>
                                    ))
                                ) : (
                                    <li>No items found in your cart.</li>
                                )}
                            </ul>
                            <div className="flex justify-between font-semibold border-t pt-2">
                                <span>Total:</span>
                                <span>{formatMoney(cart.total_amount)}</span>
                            </div>
                        </div>
                        <div className="flex gap-3 mt-6">
                            <Button asChild>
                                <Link href={dashboard().url}>Return to Dashboard</Link>
                            </Button>
                            <Button asChild variant="secondary">
                                <Link href="/products">Continue Shopping</Link>
                            </Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </OrderLayout>
    );
}
