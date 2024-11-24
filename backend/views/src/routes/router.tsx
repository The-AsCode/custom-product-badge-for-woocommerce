import { __ } from '@wordpress/i18n';
import { Outlet, createHashRouter } from 'react-router-dom';
import Main from '../layout/Main';
import BadgesEditor from '../pages/Badges/BadgesEditor/BadgesEditor';
import BadgesManager from '../pages/Badges/BadgesManager/BadgesManager';
import FilterEditor from '../pages/FilterEditor/FilterEditor';
import Filters from '../pages/Filters/Filters';

const router = createHashRouter([
  {
    path: '/',
    element: <Main />,
    children: [
      {
        path: '/',
        element: <BadgesManager />,
      },
      {
        path: 'editor',
        element: <BadgesEditor />,
      },
      {
        path: '/filters',
        element: <Outlet />,
        children: [
          {
            index: true,
            element: <Filters />,
          },
          {
            path: 'editor',
            element: <FilterEditor />,
          },
        ],
      },
    ],
  },

  {
    path: '*',
    element: <div> {__('Page Not Found', 'custom-product-badge-for-woocommerce')}</div>,
  },
]);

export default router;
