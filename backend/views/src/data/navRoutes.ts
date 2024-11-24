import { __ } from '@wordpress/i18n';

type RouteKeys = '/' | 'editor' | 'filters';

type Routes = Partial<{
  [key in RouteKeys]: string;
}>;

const navRoutes: Routes = {
  '/': __('Badges', 'custom-product-badge-for-woocommerce'),
  editor: __('Badge Editor', 'custom-product-badge-for-woocommerce'),
  // filters: __('Filters', 'custom-product-badge-for-woocommerce'),
} as const;

export default navRoutes;
