import OrderLayout from '@/layouts/order-layout';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { ProductCard } from './product-card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Products({ products }: any) {
    return (
        <OrderLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />
            <div className="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 py-10">
                {products.data.map((product: any) => (
                    <ProductCard 
                      key={product.id} 
                      product={product} 
                    />
                ))}
            </div>
        </OrderLayout>
    );
}
