import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react';
declare const CPBW: { rest_nonce: string; rest_url: string };

export const apiSlice = createApi({
  baseQuery: fetchBaseQuery({
    baseUrl: CPBW.rest_url,
    prepareHeaders: (headers) => {
      return headers.set('X-WP-Nonce', CPBW.rest_nonce);
    },
  }),
  tagTypes: ['Products', 'ProductCount', 'Badges'],
  endpoints: () => ({}),
});
