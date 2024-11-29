import buildQueryString from '../../utils/queryBuilder';
import { apiSlice } from '../api/apiSlice';

const searchApi = apiSlice.injectEndpoints({
  endpoints: (builder) => ({
    getProducts: builder.query({
      query: (query) => {
        const queryString = buildQueryString(query);
        return `search/product?${queryString}`;
      },
      providesTags: ['Products'],
    }),
  }),
});

export const { useGetProductsQuery } = searchApi;
