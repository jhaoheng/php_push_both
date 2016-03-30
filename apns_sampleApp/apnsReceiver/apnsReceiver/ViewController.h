//
//  ViewController.h
//  apnsReceiver
//
//  Created by max on 2016/3/30.
//  Copyright © 2016年 max hu. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AFNetworking.h"
#import <MessageUI/MFMailComposeViewController.h>

@interface ViewController : UIViewController<MFMailComposeViewControllerDelegate>

@property (nonatomic, retain) NSString *passToken;
@property (nonatomic, retain) NSDictionary *passUserInfo;

@property (nonatomic, strong) NSString *net_status;

@end



/*
 wanted :
 - 需要把 logView 做得更好一些
 - 延伸 nslog 的功能
 */


