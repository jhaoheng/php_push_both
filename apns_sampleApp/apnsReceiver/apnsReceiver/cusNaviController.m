//
//  cusNaviController.m
//  apnsReceiver
//
//  Created by max on 2016/3/30.
//  Copyright © 2016年 max hu. All rights reserved.
//

#import "cusNaviController.h"

@implementation cusNaviController

@synthesize description = _description;

- (void)setNaviBtnOn:(UIViewController *)naviBtnOn
{
    UIButton *menuBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    menuBtn.frame = CGRectMake(0, 0, 30, 18);
    menuBtn.backgroundColor = [UIColor redColor];
//    [menuBtn setImage:[UIImage imageNamed:@"menu"] forState:UIControlStateNormal];
    [menuBtn setTitle:@"btn" forState:UIControlStateNormal];
    [menuBtn addTarget:self action:@selector(menu_activity:) forControlEvents:UIControlEventTouchUpInside];
    
    UIBarButtonItem *leftBtn = [[UIBarButtonItem alloc] initWithCustomView:menuBtn];
    [naviBtnOn.navigationItem setLeftBarButtonItem:leftBtn];
    
}


- (void)viewDidLoad {
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor clearColor];
    
    UIImage *NavigationBackground = [[UIImage imageNamed:@"navi_bg"]
                                     resizableImageWithCapInsets:UIEdgeInsetsMake(0.1, 0.1, 0, 0.1)
                                     resizingMode:UIImageResizingModeStretch];
    
    [[UINavigationBar appearance] setBackgroundImage:NavigationBackground forBarMetrics:UIBarMetricsDefault];
    
    UIImageView *logoView = [[UIImageView alloc] initWithFrame:CGRectMake(CGRectGetWidth(self.view.frame)-70-10, 20, 70, 18)];
    logoView.image = [UIImage imageNamed:@"navi_logo.png"];
    logoView.backgroundColor = [UIColor clearColor];
    [self.navigationBar addSubview:logoView];
    
}


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
 #pragma mark - Navigation
 
 // In a storyboard-based application, you will often want to do a little preparation before navigation
 - (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
 // Get the new view controller using [segue destinationViewController].
 // Pass the selected object to the new view controller.
 }
 */


#pragma mark - menu action btn
- (void)menu_activity:(id)sender
{
    
    if (!slideController.is_lock) {
        [slideViewController switchSlideMove];
    }
}

@end
