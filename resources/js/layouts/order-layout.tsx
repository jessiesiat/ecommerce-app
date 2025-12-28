import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface OrderLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default ({ children, breadcrumbs, ...props }: OrderLayoutProps) => (
    <AppHeaderLayout breadcrumbs={breadcrumbs} {...props}>
        {children}
    </AppHeaderLayout>
);
