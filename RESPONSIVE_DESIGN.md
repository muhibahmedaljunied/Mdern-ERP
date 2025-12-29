# Responsive Design Implementation

This document describes the responsive design implementation for the ERP system.

## Overview

The project has been enhanced with comprehensive responsive design features to ensure optimal viewing and interaction across all devices - from mobile phones (320px+) to desktop computers (1200px+).

## Features Implemented

### 1. **Responsive Stylesheet** (`assets/scss/responsive/_responsive.scss`)
   - Mobile-first approach
   - Breakpoints:
     - Mobile: 320px - 575px
     - Tablet: 576px - 767px
     - Desktop: 768px - 991px
     - Large Desktop: 992px+

### 2. **Components Made Responsive**

   #### Tables
   - Horizontal scrolling on mobile devices
   - Stacked layout option for very small screens
   - Custom scrollbar styling
   - Font size adjustments

   #### Forms
   - Full-width inputs on mobile
   - Proper input group wrapping
   - iOS zoom prevention (16px font-size)
   - Button groups stack vertically on mobile

   #### Cards
   - Reduced padding on mobile
   - Single column layout on small screens
   - Responsive card decks and groups

   #### Navigation & Sidebar
   - Slide-out sidebar on mobile
   - Overlay backdrop
   - Touch gestures support (swipe to open/close)
   - Header adjustments for mobile

   #### Typography
   - Scaled heading sizes for mobile
   - Reduced display font sizes
   - Improved readability

   #### Modals
   - Full-width on mobile
   - Stacked buttons
   - Reduced padding

   #### Other Components
   - Responsive dropdowns
   - Pagination wrapping
   - Breadcrumb adjustments
   - Badge sizing
   - Alert padding

### 3. **JavaScript Enhancements** (`assets/js/responsive.js`)

   - **Sidebar Overlay**: Click outside to close sidebar on mobile
   - **Table Responsiveness**: Automatically wraps wide tables
   - **Window Resize Handling**: Adjusts layout on resize
   - **Touch Gestures**: Swipe right to open sidebar, swipe left to close
   - **iOS Zoom Prevention**: Ensures inputs have minimum 16px font-size
   - **Utility Functions**: 
     - `isMobileDevice()` - Check if device is mobile
     - `isTabletDevice()` - Check if device is tablet
     - `isDesktopDevice()` - Check if device is desktop

### 4. **Custom Responsive Classes**

   - `.hide-mobile` - Hide element on mobile
   - `.show-mobile-only` - Show only on mobile
   - `.hide-tablet` - Hide on tablet and below
   - `.show-desktop-only` - Show only on desktop
   - `.text-center-mobile` - Center text on mobile
   - `.text-left-mobile` - Left align on mobile
   - `.text-right-mobile` - Right align on mobile
   - `.w-100-mobile` - Full width on mobile

## Breakpoints

| Device | Breakpoint | Description |
|--------|-----------|-------------|
| Mobile | < 576px | Small phones |
| Tablet | 576px - 767px | Large phones, small tablets |
| Desktop | 768px - 991px | Tablets, small laptops |
| Large Desktop | ≥ 992px | Laptops, desktops |

## Usage Examples

### Making a Table Responsive

```html
<!-- Option 1: Use Bootstrap's table-responsive class -->
<div class="table-responsive">
  <table class="table">
    <!-- table content -->
  </table>
</div>

<!-- Option 2: Use custom table-stack class for stacked layout on mobile -->
<table class="table table-stack">
  <thead>
    <tr>
      <th data-label="Name">Name</th>
      <th data-label="Email">Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td data-label="Name">John Doe</td>
      <td data-label="Email">john@example.com</td>
    </tr>
  </tbody>
</table>
```

### Hiding/Showing Elements

```html
<!-- Hide on mobile -->
<div class="hide-mobile">Desktop only content</div>

<!-- Show only on mobile -->
<div class="show-mobile-only">Mobile only content</div>

<!-- Hide on tablet and below -->
<div class="hide-tablet">Desktop only content</div>
```

### Responsive Forms

```html
<!-- Forms automatically become responsive, but you can enhance them -->
<form>
  <div class="form-row">
    <div class="col-md-6">
      <input type="text" class="form-control" placeholder="Name">
    </div>
    <div class="col-md-6">
      <input type="email" class="form-control" placeholder="Email">
    </div>
  </div>
</form>
```

## Testing

To test the responsive design:

1. **Browser DevTools**: Use Chrome/Firefox DevTools responsive mode
2. **Real Devices**: Test on actual mobile devices
3. **Online Tools**: Use tools like BrowserStack or Responsive Design Checker

### Recommended Test Sizes:
- iPhone SE: 375px
- iPhone 12/13: 390px
- iPhone 12/13 Pro Max: 428px
- iPad: 768px
- iPad Pro: 1024px
- Desktop: 1920px

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Notes

1. **Viewport Meta Tag**: Already configured in layout files
2. **SCSS Compilation**: Make sure to compile SCSS after changes
3. **JavaScript**: The responsive.js file should be loaded after jQuery
4. **Touch Gestures**: Swipe gestures work on touch devices only

## Future Enhancements

Potential improvements:
- [ ] Add more breakpoints for ultra-wide screens
- [ ] Implement lazy loading for images on mobile
- [ ] Add offline support for mobile
- [ ] Optimize images for different screen densities
- [ ] Add dark mode support

## Compiling SCSS

If you need to compile the SCSS files:

```bash
# Using npm/node-sass
npm run dev

# Or using Laravel Mix
npm run production
```

## Support

For issues or questions about responsive design, please refer to the main project documentation or contact the development team.

