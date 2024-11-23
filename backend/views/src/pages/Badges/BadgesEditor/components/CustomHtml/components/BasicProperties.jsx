// @ts-nocheck
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelector } from 'react-redux';
import Input from '../../../../../../components/Input';
import Label from '../../../../../../components/Label';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';
import SectionContainer from '../../Common/SectionContainer';

const BasicProperties = () => {
  const dispatch = useDispatch();
  const { badge_settings } = useSelector((state) => state.badges);
  const handleStyleChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name, value }));
  };
  return (
    <SectionContainer className='wmx-mt-6' title={__('Basic Property')}>
      <div className='wmx-flex wmx-flex-col wmx-gap-0.5'>
        <Label htmlFor='margin'>Margin:</Label>
        <Input
          id='margin'
          type='number'
          value={badge_settings.margin}
          className='wmx-w-44'
          onChange={(e) => handleStyleChange('margin', e.target.value)}
        />
      </div>
    </SectionContainer>
  );
};
export default BasicProperties;
