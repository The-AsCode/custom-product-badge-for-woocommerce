// @ts-nocheck
import cn from '../../../../../utils/cn';

const PlaceHolderTip = ({ className }) => {
  const handleCopy = (value) => {
    window.navigator.clipboard.writeText(value);
  };
  return (
    <p className={cn('wmx-text-sm wmx-mt-4 wmx-leading-6', className)}>
      <span className='wmx-font-semibold'>Tip: </span>Use placeholders like{' '}
      <code
        title='Click To Copy!'
        className='wmx-cursor-pointer'
        onClick={() => handleCopy('{{discount_percentage}}')}
      >{`{{discount_percentage}}`}</code>
      ,{' '}
      <code
        title='Click To Copy!'
        className='wmx-cursor-pointer'
        onClick={() => handleCopy('{{discount_value}}')}
      >{`{{discount_value}}`}</code>
      ,{' '}
      <code
        title='Click To Copy!'
        className='wmx-cursor-pointer'
        onClick={() => handleCopy('{{regular_price}}')}
      >{`{{regular_price}}`}</code>
      , and{' '}
      <code
        title='Click To Copy!'
        className='wmx-cursor-pointer'
        onClick={() => handleCopy('{{sale_price}}')}
      >{`{{sale_price}}`}</code>{' '}
      to show discount and price details.
    </p>
  );
};
export default PlaceHolderTip;
