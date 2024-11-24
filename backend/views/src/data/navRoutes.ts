import { __ } from '@wordpress/i18n';

type RouteKeys = '/' | 'editor' | 'filters';

type Routes = Partial<{
  [key in RouteKeys]: string;
}>;

const navRoutes: Routes = {
  '/': __('Badges', 'store-manager-for-woocommerce'),
  editor: __('Badge Editor', 'store-manager-for-woocommerce'),
  // filters: __('Filters', 'store-manager-for-woocommerce'),
} as const;

export default navRoutes;
