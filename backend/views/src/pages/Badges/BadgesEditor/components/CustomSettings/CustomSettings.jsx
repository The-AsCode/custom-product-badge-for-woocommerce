// @ts-nocheck
import BadgeColors from './components/BadgeColors/BadgeColors';
import BadgeContents from './components/BadgeContents';
import BadgeDimension from './components/BadgeDimension';
import OtherProperty from './components/OtherProperty';

const CustomSettings = () => {
  return (
    <>
      <BadgeContents />
      <BadgeDimension />
      <BadgeColors />
      <OtherProperty />
      {/* <BadgeShape /> */}
    </>
  );
};
export default CustomSettings;
