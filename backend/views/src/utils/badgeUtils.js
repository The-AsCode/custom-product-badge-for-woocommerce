// @ts-nocheck
import badgeImages from '../../assets/badge/badgeImageData.json';
const getPositionStyles = (position) => {
  switch (position) {
    case 'top-left':
      return 'top: 0; left: 0;';
    case 'top-right':
      return 'top: 0; right: 0;';
    case 'bottom-left':
      return 'bottom: 0; left: 0;';
    case 'bottom-right':
      return 'bottom: 0; right: 0;';
    case 'center':
      return 'top: 50%; left: 50%; transform: translate(-50%, -50%);';
    default:
      return '';
  }
};

export const clipPaths = {
  0: '',
  1: 'clip-path: polygon(50% 0%, 0% 100%, 100% 100%);',
  2: 'clip-path: polygon(10% 0%, 90% 0%, 100% 100%, 0% 100%);',
  3: 'clip-path: polygon(0% 0%, 100% 0%, 90% 100%, 10% 100%);',
  4: 'clip-path: polygon(15% 0%, 100% 0%, 85% 100%, 0% 100%);',
  5: 'clip-path: polygon(0% 0%, 85% 0%, 100% 100%, 15% 100%);',
  6: 'clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);',
  7: 'clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);',
  8: 'clip-path: polygon(20% 0%, 80% 0%, 100% 20%, 100% 80%, 80% 100%, 20% 100%, 0% 80%, 0% 20%);',
  9: 'clip-path: polygon(0% 15%, 15% 15%, 15% 0%, 85% 0%, 85% 15%, 100% 15%, 100% 85%, 85% 85%, 85% 100%, 15% 100%, 15% 85%, 0% 85%);',
  10: 'clip-path: polygon(40% 0%, 40% 20%, 100% 20%, 100% 80%, 40% 80%, 40% 100%, 0% 50%);',
  11: 'clip-path: polygon(0% 20%, 60% 20%, 60% 0%, 100% 50%, 60% 100%, 60% 80%, 0% 80%);',
  12: 'clip-path: polygon(15% 0%, 100% 0%, 100% 100%, 15% 100%, 0% 50%);',
  13: 'clip-path: polygon(0% 0%, 85% 0%, 100% 50%, 85% 100%, 0% 100%);',
  14: 'clip-path: polygon(100% 0%, 85% 50%, 100% 100%, 15% 100%, 0% 50%, 15% 0%);',
  15: 'clip-path: polygon(85% 0%, 100% 50%, 85% 100%, 0% 100%, 15% 50%, 0% 0%);',
};

const getClipPath = (key = 0) => {
  return clipPaths[key];
};

export const generateBadgeHtml = (badge_settings) => {
  return `<div>
    <div class="cpbw-badge-container">${badge_settings.text}</div>

  <style>
  .cpbw-badge-container {
      margin:${badge_settings.margin}px;
      color: ${badge_settings.color};
      background: ${badge_settings.background};
      height: ${badge_settings.height}px;
      width: ${badge_settings.width}px;
      border-top-left-radius: ${badge_settings.borderTopLeftRadius}px;
      border-top-right-radius: ${badge_settings.borderTopRightRadius}px;
      border-bottom-left-radius: ${badge_settings.borderBottomLeftRadius}px;
      border-bottom-right-radius: ${badge_settings.borderBottomRightRadius}px;
      font-size: ${badge_settings.fontSize}px;
      font-weight: ${badge_settings.fontWeight};
      border: ${badge_settings.borderWidth}px solid ${badge_settings.borderColor};
      ${getPositionStyles(badge_settings.position)}
      ${getClipPath(badge_settings.clipKey)}
      position: absolute;
      z-index: 999;
      display: flex;
      align-items: center;
      justify-content: center;
  }
  </style>
  </div>`;
};

export const badgeCustomSettings = {
  filterType: 'all',
  text: 'New Arrival',
  position: 'top-right',
  color: '#ffffff',
  background: 'linear-gradient(90deg, RGB(47, 232, 53) 0%, rgba(11,194,219,1) 100%)',
  height: 34,
  width: 110,
  margin: 8,
  borderTopLeftRadius: 20,
  borderTopRightRadius: 20,
  borderBottomLeftRadius: 20,
  borderBottomRightRadius: 20,
  fontSize: 14,
  fontWeight: 700,
  borderWidth: 2,
  borderColor: 'rgb(49, 174, 188)',
  clipKey: 0,
};

export const generateImageBadgeHtml = (badge_settings) => {
  return `<img src="${
    badge_settings.type === 'default'
      ? `${CPBW.badge_image_file}${badge_settings?.image?.src}`
      : badge_settings.uploadedUrl
  }" style="
      margin: ${badge_settings.margin}px;
      height: ${badge_settings.height}px;
      width: ${badge_settings.width}px;
      object-fit: contain;
      ${getPositionStyles(badge_settings.position)}
      position: absolute;
      z-index: 999;
    "></img>`;
};

export const badgeImageSettings = {
  filterType: 'all',
  position: 'top-right',
  selectedBadgeGroup: Object.keys(badgeImages.badges)[0],
  image: badgeImages.badges[Object.keys(badgeImages.badges)[0]][0],
  height: 50,
  width: 50,
  margin: 10,
  type: 'default',
  uploadedUrl: '',
};

export const generateHtmlBadgeHtml = (badge_settings) => {
  return `<div style='
      margin:${badge_settings.margin}px;
      ${getPositionStyles(badge_settings.position)}
      position: absolute;
      z-index: 999;
    '>
    ${badge_settings.htmlContent}
    <style>
    ${badge_settings.cssContent}
    </style>
    </div>`;
};

export const htmlBadgeSettings = {
  filterType: 'all',
  position: 'top-right',
  margin: 10,
  htmlContent: '<div class="cpbw-badge-container">\n  Winter Sale\n</div>\n',
  cssContent:
    '.cpbw-badge-container {\n  color: white; \n  background: linear-gradient(to right, #0A3981, #1F509A);\n  border: 2px solid #3e7fe0;\n  padding: 4px 16px;\n  border-radius: 20px;\n  font-size: 14px;\n  cursor: pointer;\n}\n\n  .main:hover {\n    background: linear-gradient(to right, #1F509A, #0A3981);\n  }',
};
